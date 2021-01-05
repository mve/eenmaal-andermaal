<?php

namespace App\Http\Controllers\Admin;

use App\Auction;
use App\AuctionHit;
use App\Category;
use App\DB;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
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
    public function index(Request $request)
    {
        $data = User::getCreatedUsersLastMonth();
        $usersCreatedTotal = [];
        $created_at = [];

        foreach ($data as $dateWithUserCount)
        {
            array_push($usersCreatedTotal, $dateWithUserCount['total']);
            $date = Carbon::create($dateWithUserCount['created_at'])->format('d-m-Y');
            array_push($created_at, $date);
        }

        $usersTotal = DB::selectOne("SELECT COUNT(id) as total_users FROM users");
        $bidsTotal = DB::selectOne("SELECT COUNT(id) as total_bids FROM bids");
        $auctionsTotal = DB::selectOne("SELECT COUNT(id) as total_auctions FROM auctions");

        $data = AuctionHit::getAuctionHitsLastMonth();
        $auctionHitsTotal = [];
        $auctionHitsCreatedAt = [];

        foreach ($data as $dateWithUserCount)
        {
            array_push($auctionHitsTotal, $dateWithUserCount['unique_visits_last_month']);
            $date = Carbon::create($dateWithUserCount['created_at'])->format('d-m-Y');
            array_push($auctionHitsCreatedAt, $date);
        }

        $data = [
            "usersCreatedTotal" => $usersCreatedTotal,
            "usersCreatedAt" => $created_at,
            "auctionHitsToday" => AuctionHit::getAuctionHitsToday(),
            "auctionHitsTotal" => $auctionHitsTotal,
            "auctionHitsCreatedAt" => $auctionHitsCreatedAt,
            "usersTotal" => $usersTotal,
            "bidsTotal" => $bidsTotal,
            "auctionsTotal" => $auctionsTotal
        ];

        return view('admin.index')->with($data);
    }
}
