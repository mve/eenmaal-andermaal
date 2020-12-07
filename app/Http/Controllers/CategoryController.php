<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Category;
use App\DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function filtered($id, Request $request)
    {
        $category = Category::oneWhere("id", $id);

        // Get auctions in category.
        $auctions = DB::select("SELECT a.id, a.title, a.description, a.start_price, a.payment_instruction, a.duration, a.end_datetime, a.city, a.country_code
            FROM auctions a
            LEFT JOIN auction_categories ac ON a.id = ac.auction_id WHERE ac.category_id = " . $category->id);

        $auctions = Auction::resultArrayToClassArray($auctions);

        // Apply price filter.
        if ($request->get('inputMinPrice') || $request->get('inputMaxPrice')) {
            $auctions = $this->applyPriceFilter($request->get('inputMinPrice'), $request->get('inputMaxPrice'), $auctions);
        }

        $data = [
            "category" => $category,
            "auctions" => $auctions,
            "filters" => [
                'minPrice' => $request->get('inputMinPrice'),
                'maxPrice' => $request->get('inputMaxPrice'),
            ]
        ];

        // Distance calculation

        // function distance($lat1, $lon1, $lat2, $lon2) {
        //$pi80 = M_PI / 180;
        //$lat1 *= $pi80;
        //$lon1 *= $pi80;
        //$lat2 *= $pi80;
        //$lon2 *= $pi80;
        //$r = 6372.797; // mean radius of Earth in km
        //$dlat = $lat2 - $lat1;
        //$dlon = $lon2 - $lon1;
        //$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        //$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        //$km = $r * $c;
        ////echo ' '.$km;
        //return $km;
        //}

        return view('category.view')->with($data);
    }

    /**
     * @param int $minPrice
     * @param int $maxPrice
     * @param array $auctions
     *
     * @return array
     */
    public function applyPriceFilter($minPrice, $maxPrice, array $auctions)
    {
        $filteredAuctions = [];

        foreach ($auctions as $auction) {
            $bid = $auction->getLatestBid();

            if (($minPrice === null || $bid >= $minPrice) && ($maxPrice === null || $bid <= $maxPrice)) {
                array_push($filteredAuctions, $auction);
            }

        }

        return $filteredAuctions;

    }

}
