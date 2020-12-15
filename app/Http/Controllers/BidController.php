<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Bid;
use App\Mail\Outbid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class BidController extends Controller
{
    /**
     * Post a bid to the auction
     * @param $id
     * @param $amount
     * @return \Illuminate\Http\JsonResponse
     */
    public function bid($id, $amount)
    {
        if (!Session::has('user'))
            return response()->json(['error' => 'Je moet eerst inloggen']);
        $auction = Auction::oneWhere("id", $id);
        if (!$auction)
            return response()->json(['error' => 'Veiling niet gevonden']);
        if (Carbon::now() >= Carbon::parse($auction->end_datetime))
            return response()->json(['error' => 'De veiling is al afgelopen']);
        $latestBid = $auction->getLatestBid();
        $minimumBid = $latestBid + $auction->getIncrement();
        if ($amount < $minimumBid) {
            return response()->json([
                'error' => 'Bod moet minimaal &euro;'.$minimumBid." zijn",
                'currentBid' => $latestBid,
                'lastFiveBidsHTML' => $auction->getLastNBidsHTML()
            ]);
        }

        $latestBid = $auction->getLatestBidObject();

        $bid = new Bid();
        $bid->auction_id = $auction->id;
        $bid->user_id = Session::get('user')->id;
        $bid->amount = $amount;
        $bid->save();

        if($latestBid){
            $lastBidder = $latestBid->getBidder();
            $user = Session::get('user');
            if($lastBidder->id != $user->id)
                Mail::to($lastBidder->email)->send(new Outbid($auction->title, $auction->id));
        }

        return response()->json([
            'success' => 'Bod geplaatst!',
            'currentBid' => $auction->getLatestBid(),
            'lastFiveBidsHTML' => $auction->getLastNBidsHTML()
        ]);
    }

    /**
     * Load the current auction bid data
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadData($id)
    {
        $auction = Auction::oneWhere("id", $id);
        if (!$auction)
            return response()->json(['error' => 'Veiling niet gevonden']);
        return response()->json([
            'success' => "Biedingen geladen",
            'currentBid' => $auction->getLatestBid(),
            'lastFiveBidsHTML' => $auction->getLastNBidsHTML()
        ]);
    }
}
