<?php

namespace App\Http\Controllers;

use App\Auction;
use App\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckUser;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware(CheckUser::class);
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
            "auctions" => Auction::resultArrayToClassArray(DB::select("
                SELECT TOP 10 *
                FROM eenmaalandermaal.dbo.auctions
                WHERE EXISTS (
                    SELECT TOP 10 auction_id, COUNT(auction_id) as Cnt
                    FROM eenmaalandermaal.dbo.auction_hits WHERE auction_id=eenmaalandermaal.dbo.auctions.id AND hit_datetime >= DATEADD(HOUR, -1, GETDATE())
                    GROUP BY auction_id
                    ORDER BY Cnt DESC
                )
            "))
        ];
        return view('home')->with($data);
    }
}
