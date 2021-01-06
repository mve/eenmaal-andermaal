<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Auction;
use App\DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check.admin');
    }

    /**
     * Show the list of users
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function list(Request $request)
    {
        $query = "
        WITH acactive AS(
        SELECT users.id, COUNT(ac1.id) as Active
        FROM users
        LEFT JOIN auctions ac1
        ON ac1.user_id = users.id
        WHERE ac1.end_datetime >= GETDATE()
        GROUP BY users.id
        )
        , acall AS(
        SELECT users.id, COUNT(ac2.id) as AllCnt
        FROM users
        LEFT JOIN auctions ac2
        ON ac2.user_id = users.id
        GROUP BY users.id
        )

        SELECT users.*, acactive.Active, acall.AllCnt
        FROM users
        LEFT JOIN acactive
        ON acactive.id=users.id
        LEFT JOIN acall
        ON acall.id=users.id
        ";

        $limit = 15;
        $page = ($request->has("page")) ? (is_numeric($request->get("page")) ? $request->get("page") : 1) : 1;
        $offsetPage = ($page<=0)? 0 : $page-1 ;
        $offset = $offsetPage*$limit;
        $querySelectCount = str_replace("SELECT users.*, acactive.Active, acall.AllCnt","SELECT COUNT(users.id)",$query);

        $eaPaginationTotalItems = DB::selectOne($querySelectCount)['computed'];
        $eaPaginationCurrentPage = $page;
        $eaPaginationTotalPages = ceil($eaPaginationTotalItems / $limit);

        $query .= " ORDER BY users.username ASC OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY";
        $users = User::resultArrayToClassArray(DB::select($query));
        $data = [
            "users" => $users,
            'paginationData' => [
                'totalItems' => $eaPaginationTotalItems,
                'totalPages' => $eaPaginationTotalPages,
                'currentPage' => $eaPaginationCurrentPage,
            ]
        ];
        return view('admin.users.list')->with($data);
    }

    /**
     * Show the an individual user's page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function view(Request $request)
    {
        $user = User::oneWhere('id', $request->id);

        $sql = 'SELECT a.id, a.title, a.end_datetime, ISNULL(b.amount, a.start_price) AS amount
        FROM auctions a
        OUTER APPLY (
            SELECT TOP 1 b.amount
            FROM bids b
            WHERE a.id = b.auction_id
            ORDER BY b.created_at DESC
        ) as b
        WHERE a.user_id =:user_id AND a.end_datetime /xd/ GETDATE()
        ORDER BY a.end_datetime DESC';

        $auctions = Auction::resultArrayToClassArray(DB::select(str_replace("/xd/", ">=", $sql), ['user_id' => $user->id]));
        $pastAuctions = Auction::resultArrayToClassArray(DB::select(str_replace("/xd/", "<", $sql), ['user_id' => $user->id]));
        $bids = Auction::resultArrayToClassArray(DB::select(
            '-- https://stackoverflow.com/questions/2411559/how-do-i-query-sql-for-a-latest-record-date-for-each-user
            DECLARE @userId int
            SET @userId =:user_id;

            WITH bidsplacedtotal AS (
                SELECT amount, user_id, auction_id
                FROM bids WHERE user_id = @userId
            ), bidsplaced AS (
                SELECT amount
                FROM bidsplacedtotal bt INNER JOIN
                (SELECT auction_id, max(amount) as maxAmount FROM bids WHERE user_id = @userId GROUP BY auction_id) bm
                ON bt.auction_id = bm.auction_id AND bt.amount = bm.maxAmount
            ), bidsreceivedtotal AS (
                SELECT amount, user_id, auction_id
                FROM bids WHERE auction_id IN
                (SELECT id FROM auctions WHERE user_id = @userId)
            ), bidsreceived AS (
                SELECT amount
                FROM bidsreceivedtotal bt INNER JOIN
                (SELECT auction_id, max(amount) AS maxAmount FROM bids GROUP BY auction_id) bm
                ON bt.auction_id = bm.auction_id AND bt.amount = bm.maxAmount
            )

            SELECT
            (SELECT COUNT(amount) FROM bidsplaced) AS placed,
            (SELECT ISNULL(SUM(amount), 0) FROM bidsplaced) AS amount_placed,
            (SELECT COUNT(amount) FROM bidsplacedtotal) AS placed_total,
            (SELECT ISNULL(SUM(amount), 0) FROM bidsplacedtotal) AS amount_placed_total,
            (SELECT COUNT(amount) FROM bidsreceived) AS received,
            (SELECT ISNULL(SUM(amount), 0) FROM bidsreceived) AS amount_received,
            (SELECT COUNT(amount) FROM bidsreceivedtotal) AS received_total,
            (SELECT ISNULL(SUM(amount), 0) FROM bidsreceivedtotal) AS amount_received_total',
            ['user_id' => $user->id]
        ));

        $views = Auction::resultArrayToClassArray(DB::select(
            'WITH auctionsviewed AS (
            SELECT created_at FROM auction_hits WHERE user_id =:user_id
        )

        SELECT
        (SELECT COUNT(created_at) FROM auctionsviewed) AS total,
        (SELECT COUNT(created_at) FROM auctionsviewed WHERE created_at > dateadd(DD, -1, cast(GETDATE() as date))) AS today',
            ['user_id' => $user->id]
        ));

        $data = [
            'user' => $user,
            'auctions' => $auctions,
            'pastAuctions' => $pastAuctions,
            'bids' => $bids[0],
            'views' => $views[0]
        ];
        return view('admin.users.view')->with($data);
    }

    /**
     * @param Request $request
     * @return redirect to last page
     */
    public function toggleBlock(Request $request, $id)
    {
        $block = $request->has('unblock') ? 0 : 1;
        DB::insertOne('UPDATE users SET is_blocked =:block WHERE id =:id', ['block' => $block, 'id' => $id]);
        return redirect(url()->previous());
    }
}
