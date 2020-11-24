<?php


namespace App;


use Carbon\Carbon;
use Facade\Ignition\Support\Packagist\Package;

class Auction extends SuperModel
{
    /**
     * Get the auction's seller
     * @return mixed
     */
    public function getSeller()
    {
        $seller = User::oneWhere("id", $this->user_id);
        return $seller;
    }

    /**
     * Get the auction's shipping methods
     * @return array
     */
    public function getShippingMethods()
    {
        $shippingMethods = DB::select("
            SELECT *
            FROM auction_shipping_methods
            RIGHT JOIN shipping_methods
            ON auction_shipping_methods.shipping_id = shipping_methods.id
            WHERE auction_shipping_methods.auction_id = :id",
            [
                "id" => $this->id
            ]);
        return $shippingMethods;
    }

    /**
     * Get the auction's payment methods
     * @return array
     */
    public function getPaymentMethods()
    {
        $paymentMethods = DB::select("
            SELECT *
            FROM auction_payment_methods
            RIGHT JOIN payment_methods
            ON auction_payment_methods.payment_id = payment_methods.id
            WHERE auction_payment_methods.auction_id = :id",
            [
                "id" => $this->id
            ]);
        return $paymentMethods;
    }

    /**
     * Get the auction's images
     * @return array
     */
    public function getImages()
    {
        $images = DB::select("
            SELECT file_name
            FROM auction_images
            WHERE auction_id=:id",
            [
                "id" => $this->id
            ]);
        return $images;
    }

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
            if($popularAuctionsCount===0){
                $addAuctions = Auction::resultArrayToClassArray(DB::select("
                    SELECT TOP $maxn *
                    FROM auctions ORDER BY end_datetime ASC"));
            }else{
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
            }
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

    /**
     * Get the auction's bids
     * @return mixed
     */
    public function getBids()
    {
        return Bid::resultArrayToClassArray(DB::select("
            SELECT *
            FROM bids
            WHERE auction_id=:id
            ORDER BY amount DESC
            ",
            [
                "id" => $this->id
            ]));
    }

    /**
     * Get the average review score
     * @return false|float|int
     */
    public function getReviewAverage()
    {
        $positiveReviews = $this->getPositiveReviews();
        return count($this->getReviews()) > 0 ? round(($positiveReviews * 5) / ($positiveReviews + $this->getNegativeReviews())) : 0;
    }

    /**
     * Get the auction's positive reviews
     * @return mixed
     */
    public function getPositiveReviews()
    {
        $result = DB::selectOne("
            SELECT COUNT(is_positive) as Cnt,reviews.auction_id
            FROM reviews
            WHERE auction_id=:id AND is_positive=1
            GROUP BY auction_id
            ORDER BY Cnt DESC
            ",
            [
                "id" => $this->id
            ]);
        if ($result !== false)
            return $result["Cnt"];
        return 0;
    }

    /**
     * Get the auction's country
     * @return mixed
     */
    public function getCountry()
    {
        return DB::selectOne("SELECT country FROM countries WHERE country_code=:country_code",[
            "country_code" => $this->country_code
        ])["country"];
    }

    /**
     * Get the auction's negative reviews
     * @return mixed
     */
    public function getNegativeReviews()
    {
        $result = DB::selectOne("
            SELECT COUNT(is_positive) as Cnt,reviews.auction_id
            FROM reviews
            WHERE auction_id=:id AND is_positive=0
            GROUP BY auction_id
            ORDER BY Cnt DESC
            ",
            [
                "id" => $this->id
            ]);
        if ($result !== false)
            return $result["Cnt"];
        return 0;
    }

    /**
     * Get the auction's reviews
     * @return mixed
     */
    public function getReviews()
    {
        return Review::resultArrayToClassArray(DB::select("
            SELECT *
            FROM reviews
            WHERE auction_id=:id
            ",
            [
                "id" => $this->id
            ]));
    }
}
