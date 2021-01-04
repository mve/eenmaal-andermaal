<?php

namespace App\Http\Controllers\Admin;

use App\Auction;
use App\AuctionHit;
use App\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Auctioncontroller extends Controller
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


    public function list()
    {

        $auctions = DB::select("
            SELECT TOP 10 auctions.* , users.first_name , users.last_name
            FROM auctions LEFT JOIN users
            ON users.id = auctions.user_id
            ORDER BY auctions.id
            ");


        $auctions = Auction::resultArrayToClassArray($auctions);

        $data = [
            "auctions" => $auctions,
        ];
       // dd($data);
        return view('admin.auctions.list')->with($data);
    }
}
