<?php

namespace App\Http\Controllers\Admin;

use App\Bid;
use App\DB;
use App\Auction;
use App\User;
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
        return view('admin.auctions.list');
    }

    public function view(Request $request)
    {
        $auction = Auction::oneWhere('id', $request->id);
        // $auction = Auction::resultArrayToClassArray(DB::selectOne('
        //     select a.id, a.title, a.description, a.start_price, a.duration, a.end_datetime, a.user_id, a.created_at, u.first_name, u.last_name
        //     FROM auctions AS a
        //     INNER JOIN users AS u 
        //     ON a.user_id = u.id
        //     AND a.id =:auction_id
        // ', ['auction_id' => $request->id]));

        if ($auction === false) {
            return abort(404);
        }

        $user = User::resultArrayToClassArray(DB::select(
            'SELECT first_name, last_name 
            FROM users WHERE id =:user_id',
            ['user_id' => $auction->user_id]
        ));

        $bids = Bid::resultArrayToClassArray(DB::select(
            'SELECT max(amount) as amount, count(amount) as count 
            FROM bids 
            WHERE auction_id =:auction_id 
            GROUP BY auction_id',
            ['auction_id' => $auction->id]
        ));

        $auctionImages = $auction->getImages();

        $data = [
            'auction' => $auction,
            'auctionImages' => $auctionImages,
            'user' => $user[0],
            'bids' => $bids ? $bids[0] : null
        ];
        
        return view('admin.auctions.view')->with($data);
    }

    /**
     * @param Request $request
     * @return redirect to last page
     */
    public function toggleBlock(Request $request, $id)
    {
        $block = $request->has('unblock') ? 0 : 1;
        DB::insertOne('UPDATE auctions SET is_blocked =:block WHERE id =:id', ['block' => $block, 'id' => $id]);
        return redirect(url()->previous());
    }
}
