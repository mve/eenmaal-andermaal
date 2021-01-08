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
                    "ip" => request()->ip()
                ]);
            } else if ($request->cookie('cookie_allow') == 0){
                AuctionHit::insert([
                    "auction_id" => $auction->id,
                    'user_id' => $userId,
                    "ip" => "0.0.0.0"
                ]);
            }
        }

    }

    public static function getHits($auction)
    {
        $time = Carbon::now();
        $time->subHour();
        $time = $time->format('Y-m-d H:i:s');

        $unique_visits_last_hour = DB::select("SELECT count(distinct ip) as unique_visits_last_hour FROM auction_hits WHERE created_at>=:time AND auction_id =:auction_id", [
            "time" => $time,
            "auction_id" => $auction->id
        ]);

        return $unique_visits_last_hour[0]['unique_visits_last_hour'];
    }

    public static function getAuctionHitsToday()
    {
        $time = Carbon::now();
        $time = $time->format('Y-m-d');

        $unique_visits_today = DB::select("SELECT count(distinct ip) as unique_visits_today FROM auction_hits WHERE created_at>=:time", [
            "time" => $time,
        ]);

        return $unique_visits_today[0]['unique_visits_today'];
    }

    public static function getAuctionHitsLastMonth()
    {
        $timeNow = Carbon::now();

        $time = Carbon::now();
        $time->subtract('1 month');
        $time = $time->format('Y-m-d');

        return DB::select("
            select count(distinct ip) as unique_visits_last_month, dateadd(DAY,0, datediff(day,0, created_at)) as created_at
            from auction_hits
            WHERE created_at > :time AND created_at < :timeNow
            group by dateadd(DAY,0, datediff(day,0, created_at))
            ORDER BY created_at ASC
            ",
            [
                "time" => $time,
                "timeNow" => $timeNow
            ]);
    }


}
