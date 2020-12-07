<?php


namespace App;


use Carbon\Carbon;
use Facade\Ignition\Support\Packagist\Package;
use Illuminate\Support\Facades\Session;

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
     * Get the auction's first image or use the placeholder
     * @return string
     */
    public function getFirstImage()
    {
        $image = DB::selectOne("
            SELECT TOP 1 file_name
            FROM auction_images
            WHERE auction_id=:id",
            [
                "id" => $this->id
            ]);
        if ($image === false) {
            return "../images/no-image.jpg";
        }
        return $image["file_name"];
    }

    /**
     * Get the auction's images or use the placeholder
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
        if (empty($images)) {
            $images = [];
            array_push($images, ["file_name" => "../images/no-image.jpg"]);
        }
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
        if ($popularAuctionsCount < $maxn) {
            if ($popularAuctionsCount === 0) {
                $addAuctions = Auction::resultArrayToClassArray(DB::select("
                    SELECT TOP $maxn *
                    FROM auctions ORDER BY end_datetime ASC"));
            } else {
                $nAddAuctions = $maxn - $popularAuctionsCount;
                $idString = "";
                for ($i = 0; $i < $popularAuctionsCount; $i++)
                    $idString .= $popularAuctions[$i]->id . ($i == $popularAuctionsCount - 1 ? "" : ",");
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
     * Retrieves the most viewed ($maxc) categories by the user with $maxn auctions
     * @param int $maxc
     * @param int $maxn
     * @return array
     */
    public static function getPersonalAuctions($maxc = 3, $maxn = 10)
    {
        $categories = [];
        if (Session::has("user")) {
            $userid = Session::get("user")->id;
            $categories = DB::select("
                SELECT TOP $maxc id,name
                FROM categories
                WHERE EXISTS (
                    SELECT TOP $maxc category_id
                    FROM auction_categories
                    WHERE EXISTS (
                        SELECT TOP 10 id
                        FROM auctions
                        WHERE EXISTS (
                            SELECT TOP 10 auction_id, COUNT(auction_id) as Cnt
                            FROM auction_hits WHERE auction_id=auctions.id AND user_id= $userid
                            GROUP BY auction_id
                            ORDER BY Cnt DESC
                        ) AND auction_id =id
                        GROUP BY id
                    ) AND category_id = categories .id
                )
            ");
            for ($i = 0; $i < count($categories); $i++) {
                $auctions = Auction::resultArrayToClassArray(DB::select("
                    SELECT TOP $maxn *
                    FROM auctions
                    WHERE EXISTS (
                        SELECT TOP 3 auction_id
                        FROM auction_categories
                        WHERE category_id = :cat_id AND auctions.id=id
                    ) AND end_datetime >= DATEADD(MINUTE, 1, GETDATE())
                ", [
                    "cat_id" => $categories[$i]["id"]
                ]));
                $categories[$i]["auctions"] = $auctions;
            }
        }
        return $categories;

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
        if ($diff->days > 1) {
            $formatString = "%d dagen %H:%I";
        } else if ($diff->days === 1) {
            $formatString = "%d dag %H:%I";
        } else {
            $formatString = "%H:%I:%S";
        }
        return $diff->format($formatString);
//        return ucfirst($parsedTime->diffForHumans());
    }

    /**
     * Get the latest bid's amount
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
     * Get the last $max bids and put them into list items
     * @param int $max
     * @return string
     */
    public function getLastNBidsHTML($max = 5)
    {
        $lastFiveBidsHTML = "";
        $lastFiveBids = $this->getBids($max);
        if(count($lastFiveBids)){
            foreach($lastFiveBids as $bid){
                $lastFiveBidsHTML .= "<li class=\"list-group-item\"><strong>".$bid->getBidder()->first_name.": &euro;".$bid->amount."</strong> <span class=\"float-right\">".$bid->getTime()."</span></li>";
            }
            return $lastFiveBidsHTML;
        }else{
            return "<li class=\"list-group-item flex-centered\"><strong>Er is nog niet geboden</strong></li>";
        }
    }

    /**
     * Get the highest bid
     * @return mixed
     */
    public function getHighestBid()
    {
        $result = DB::selectOne("SELECT TOP 1 * FROM bids WHERE auction_id=:auction_id ORDER BY amount DESC", [
            "auction_id" => $this->id
        ]);
        return $result ? Bid::resultToClass($result) : false;
    }

    /**
     * Get the auction's bids
     * @return mixed
     */
    public function getBids($max = 5)
    {
        return Bid::resultArrayToClassArray(DB::select("
            SELECT TOP $max *
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
        return number_format(DB::selectOne("
                SELECT AVG(CAST(rating as FLOAT)) as average
                FROM reviews
                WHERE auction_id IN (
                    SELECT auctions.id FROM auctions WHERE auctions.user_id=:user_id
                )
            ", [
            "user_id" => $this->user_id
        ])["average"], 2, ",", ".") ?: 0;
    }

    /**
     * Get the auction's country
     * @return mixed
     */
    public function getCountry()
    {
        return DB::selectOne("SELECT country FROM countries WHERE country_code=:country_code", [
            "country_code" => $this->country_code
        ])["country"];
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
            WHERE auction_id IN (
                SELECT auctions.id FROM auctions WHERE auctions.user_id=:user_id
            )
            ",
            [
                "user_id" => $this->getSeller()->id
            ]));
    }

    /**
     * Get the auction's reviews per star amount
     * @return mixed
     */
    public function getReviewsByRating($rating)
    {
        return Review::resultArrayToClassArray(DB::select("
            SELECT *
            FROM reviews
            WHERE auction_id IN (
                SELECT auctions.id FROM auctions WHERE auctions.user_id=:user_id
            ) AND rating=:rating_number
            ",
            [
                "user_id" => $this->user_id,
                "rating_number" => $rating
            ]));
    }

    /**
     * Get the subcategories for a certain category_id
     *
     */
    public function getSubcategoriesForCategoryId($categoryId)
    {
        return Bid::resultArrayToClassArray(DB::select("
            WITH subcategories AS(
                    SELECT  *
                    FROM    dbo.categories
                    WHERE   id = :categoryId
                    UNION ALL
                    SELECT  c.*
                    FROM    dbo.categories c INNER JOIN
                            subcategories s ON c.parent_id = s.id
            )

            SELECT  *
            FROM    subcategories
            ",
            [
                "categoryId" => $categoryId
            ]));
    }

    /**
     * Get all auctions in a category (even subcategories)
     * @return array with auctions
     */
    public static function getAllAuctionsFromParent($parentId, $limit = 6)
    {
        return Auction::resultArrayToClassArray(DB::select("
        WITH subcategories AS(
            SELECT  *
            FROM    dbo.categories
            WHERE   id = :parentId
            UNION ALL
            SELECT  c.*
            FROM    dbo.categories c INNER JOIN
                    subcategories s ON c.parent_id = s.id
        )

        SELECT c.id AS category_id, c.name AS category_name, c.parent_id AS category_parent_id,
        a.*
        FROM dbo.categories AS c, dbo.auctions AS a, dbo.auction_categories AS ac
        WHERE c.id = ac.category_id
        AND ac.auction_id = a.id
        AND ac.category_id IN (SELECT id FROM subcategories)
        ", [
            "parentId" => $parentId
        ]));
    }

    /**
     * Return all auctions per category
     * @return array of objects with name == categoryName && auctions
     */
    public static function getAllTopCategoryAuctions($limit = 6)
    {
        $topCategories = DB::select("
            SELECT *
            FROM dbo.categories
            WHERE parent_id
            IS NULL
            ORDER BY name ASC
        ");

        if (empty($topCategories)) {
            return [];
        }

        $auctions = [];

        foreach ($topCategories as $cat) {
            $auctionsPerTopCategory = Auction::getAllAuctionsFromParent($cat['id']);
            if (empty($auctionsPerTopCategory)) {
                continue;
            }
            $auctions[$cat['name']] = $auctionsPerTopCategory;
            // array_push($auctions, $auctionsPerTopCategory);
        }

        return $auctions;
    }
}
