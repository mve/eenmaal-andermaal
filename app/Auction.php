<?php


namespace App;


use Carbon\Carbon;
use Facade\Ignition\Support\Packagist\Package;

class Auction extends SuperModel
{
    /**
     * Get the most popular auctions and add auctions that will close soon if there are not enough popular auctions
     * @param int $maxn
     * @return array
     */
    public static function getPopularAuctions($maxn = 10)
    {
        $popularAuctions = Auction::resultArrayToClassArray(DB::select("
                SELECT TOP $maxn *
                FROM auctions
                WHERE EXISTS (
                    SELECT TOP $maxn auction_id, COUNT(auction_id) as Cnt
                    FROM auction_hits WHERE auction_id=auctions.id AND hit_datetime >= DATEADD(HOUR, -1, GETDATE())
                    GROUP BY auction_id
                    ORDER BY Cnt DESC
                )
            "));
        $popularAuctionsCount = count($popularAuctions);
        if($popularAuctionsCount < $maxn){
            $nAddAuctions = $maxn - $popularAuctionsCount;
            $idString = "";
            for($i = 0; $i < $popularAuctionsCount; $i++)
                $idString.=$popularAuctions[$i]->id.($i==$popularAuctionsCount-1? "":",");
            $addAuctions = Auction::resultArrayToClassArray(DB::select("
                    SELECT TOP $nAddAuctions *
                    FROM auctions
                    WHERE id NOT IN (
                        SELECT id
                        FROM auctions
                        WHERE id IN ($idString)
                ) ORDER BY end_datetime ASC"));
            $popularAuctions = array_merge($popularAuctions, $addAuctions);
        }
        return $popularAuctions;
    }

    /**
     * Get the time left for the auction
     * @return string
     */
    public function getTimeLeft()
    {
        $parsedTime = Carbon::parse($this->end_datetime);
        if (Carbon::now() >= $parsedTime)
            return "Afgelopen";
        $diff = $parsedTime->diff();
        $formatString = "%H:%I:%S";
        if ($diff->days > 0)
            $formatString = "%d dagen " . $formatString;
//        if($diff->m > 0)
//            $formatString = "%m maanden " . $formatString;
//        if($diff->y > 0)
//            $formatString = "%y jaar " . $formatString;
        return $diff->format($formatString);
    }

    /**
     * Get the latest bit as variable
     * @return mixed
     */
    public function getLatestBid()
    {
        $result = DB::selectOne("SELECT TOP 1 * FROM bids WHERE auction_id=:auction_id ORDER BY amount DESC", [
            "auction_id" => $this->id
        ]);
        if ($result === false)
            return $this->start_price;
        return Bid::resultToClass($result)->amount;
    }
}
