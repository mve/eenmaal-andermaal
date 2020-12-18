<?php


namespace App;


use Carbon\Carbon;

class AuctionHit extends SuperModel
{

    public static function hit($auction, $user, $request)
    {
        $userId = null;

        if ($user) {
            $userId = $user->id;
        }

        if ($request->cookie('cookie_allow') == 1 OR $user){
            if ($request->cookie('cookie_allow') == 1 ) {
                AuctionHit::insert([
                    "auction_id" => $auction->id,
                    'user_id' => $userId,
                    "ip" => request()->ip(),
                    "hit_datetime" => Carbon::now()
                ]);
            } else if ($request->cookie('cookie_allow') == 0){
                AuctionHit::insert([
                    "auction_id" => $auction->id,
                    'user_id' => $userId,
                    "ip" => "0.0.0.0",
                    "hit_datetime" => Carbon::now()
                ]);
            }
        }

    }

    public static function getHits($auction)
    {
        $time = Carbon::now();
        $time->subHour();
        $time = $time->format('Y-m-d H:i:s');

        $unique_visits_last_hour = DB::select("SELECT count(distinct ip) as unique_visits_last_hour FROM auction_hits WHERE hit_datetime>=:time AND auction_id =:auction_id", [
            "time" => $time,
            "auction_id" => $auction->id
        ]);

        return $unique_visits_last_hour[0]['unique_visits_last_hour'];
    }


}
