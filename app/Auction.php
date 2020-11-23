<?php


namespace App;


use Carbon\Carbon;
use Facade\Ignition\Support\Packagist\Package;

class Auction extends SuperModel
{
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
        if($diff->days > 0)
            $formatString = "%d dagen " . $formatString;
//        if($diff->m > 0)
//            $formatString = "%m maanden " . $formatString;
//        if($diff->y > 0)
//            $formatString = "%y jaar " . $formatString;
        return $diff->format($formatString);
    }

    public function getLatestBid()
    {
        $result = DB::selectOne("SELECT TOP 1 * FROM bids WHERE auction_id=:auction_id ORDER BY amount DESC",[
            "auction_id" => $this->id
        ]);
        if($result===false)
            return $this->start_price;
        return Bid::resultToClass($result)->amount;
    }
}
