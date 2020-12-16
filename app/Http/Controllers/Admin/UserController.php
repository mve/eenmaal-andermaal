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
     * Show the admin Dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function list(Request $request)
    {
        return view('admin.users.list');
    }      
    
    /**
     * Show the admin Dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function view(Request $request)
    {
        $user = User::oneWhere('id', $request->id);

        // -- SQL query
        // SELECT * FROM dbo.auctions a
        // OUTER APPLY (
        //     SELECT TOP 1 * 
        //     FROM dbo.bids b
        //     WHERE a.id = b.auction_id
        //     ORDER BY b.bid_datetime DESC
        // ) as b
        // -- optional: WHERE a.user_id = {{userid}}

        $sql = 'SELECT a.title, a.end_datetime, b.amount 
        FROM auctions a
        OUTER APPLY (
            SELECT TOP 1 b.amount 
            FROM bids b 
            WHERE a.id = b.auction_id 
            ORDER BY b.bid_datetime DESC
        ) as b 
        WHERE a.user_id =:user_id AND a.end_datetime /xd/ GETDATE()
        ORDER BY a.end_datetime DESC';

        $auctions = Auction::resultArrayToClassArray(DB::select(str_replace("/xd/", ">=", $sql), ['user_id' => $user->id]));
        $pastAuctions = Auction::resultArrayToClassArray(DB::select(str_replace("/xd/", "<", $sql), ['user_id' => $user->id]));
        $bids = Auction::resultArrayToClassArray(DB::select('
            DECLARE @userId int
            SET @userId =:user_id
            
            SELECT (
                SELECT COUNT(id)
                FROM dbo.bids
                WHERE user_id = @userId
            ) AS placed,
            (
                SELECT ISNULL(SUM(amount), 0)
                FROM dbo.bids
                WHERE user_id = @userId
            ) AS amount_placed,
            (
                SELECT COUNT(id)
                FROM dbo.bids WHERE auction_id IN (SELECT id FROM dbo.auctions WHERE user_id = @userId)
            ) AS received,
            (
                SELECT ISNULL(SUM(amount), 0)
                FROM dbo.bids WHERE auction_id IN (SELECT id FROM dbo.auctions WHERE user_id = @userId)
            ) AS amount_received', ['user_id' => $user->id]));

        $data = [
            'user' => $user,
            'auctions' => $auctions,
            'pastAuctions' => $pastAuctions,
            'bids' => $bids[0]
        ];
        return view('admin.users.view')->with($data);
    }    
}
