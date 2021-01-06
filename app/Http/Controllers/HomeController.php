<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Category;
use App\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('check.user');
        $this->middleware('check.user.is.blocked');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
//        dump(request()->ip());
//        $user = session('user');
//        $binary = inet_pton('127.0.0.1');
//        dump(inet_ntop($binary));
//        dump($user->id);
//        dump(Carbon::now());

        $data = [
            "categoryMenuHTML" => Category::getCategories(),
            "popularAuctions" => Auction::getPopularAuctions(4),
            "recentlyAddedAuctions" => Auction::getRecentlyAddedAuctions(4),
            "personalAuctions" => Auction::getPersonalAuctions(2, 4),
            "topCategoryAuctions" => Auction::getAllTopCategoryAuctions(3)
        ];
        return view('home')->with($data);
    }

    public function search(Request $request)
    {
        if ($request->search) {
            $keywords = array_map('trim', explode(",", $request->search));
        }

        if (isset($keywords)) {
            $query = "
                SELECT *
                FROM auctions
            ";
            $i = 0;
            $bindValues = [];
            foreach ($keywords as $key => $keyword) {
                $kw1 = ":kw".$i."_1";
                $kw2 = ":kw".$i."_2";
                $bindValues[$kw1] = "%".$keyword."%";
                $bindValues[$kw2] = "%".$keyword."%";
                if ($key === array_key_first($keywords)) {
                    $query .= " WHERE (title LIKE $kw1 OR description LIKE $kw2) ";
                } else {
                    $query .= " OR (title LIKE $kw1 OR description LIKE $kw2) ";
                }
                $i++;
            }
            $query .= " AND end_datetime >= GETDATE()";
            //Standard query end /\
            //Pagination begin \/
            $limit = 15;
            $page = ($request->has("page")) ? (is_numeric($request->get("page")) ? $request->get("page") : 1) : 1;
            $offsetPage = ($page<=0)? 0 : $page-1 ;
            $offset = $offsetPage*$limit;
            $querySelectCount = str_replace("SELECT *","SELECT COUNT(*)",$query);

            $eaPaginationTotalItems = DB::selectOne($querySelectCount,$bindValues)['computed'];
            $eaPaginationCurrentPage = $page;
            $eaPaginationTotalPages = ceil($eaPaginationTotalItems / $limit);

            $query .= " ORDER BY end_datetime DESC OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY";
            $auctions = Auction::resultArrayToClassArray(DB::select($query, $bindValues));

            $data = [
                "keywords" => $keywords,
                "auctions" => $auctions,
                'paginationData' => [
                    'totalItems' => $eaPaginationTotalItems,
                    'totalPages' => $eaPaginationTotalPages,
                    'currentPage' => $eaPaginationCurrentPage,
                ]
            ];

            return view('search.view')->with($data);
        } else {
            $data = [
                'paginationData' => [
                    'totalPages' => 0,
                ]
            ];
            return view('search.view')->with($data);
        }
    }

    public function cookie(Request $request)
    {
        if ($request->cookie_allow) {
            return redirect()->back()->withCookie(cookie()->forever('cookie_allow', '1'));
        } else if ($request->cookie_disallow) {
            return redirect()->back()->withCookie(cookie()->forever('cookie_allow', '0'));
        } else {
            abort(404);
        }

    }

    public function privacy(Request $request)
    {
        return view('privacy.index');
    }


}
