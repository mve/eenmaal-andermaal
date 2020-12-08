<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Category;
use App\DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use \Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function filtered($id, Request $request)
    {
        $category = Category::oneWhere("id", $id);
        $authUser = Session::get('user');
        if ($category === false)
            return redirect()->route("home");

        $children = Category::allWhere("parent_id", $category->id);
        if (count($children))
            return self::categoryChildren($category, $children);

        // Get auctions in category.
        $auctions = DB::select("SELECT a.id, a.title, a.description, a.start_price, a.payment_instruction, a.duration, a.end_datetime, a.city, a.country_code, a.user_id
            FROM auctions a
            LEFT JOIN auction_categories ac ON a.id = ac.auction_id WHERE ac.category_id = " . $category->id);

        $auctions = Auction::resultArrayToClassArray($auctions);

        // Apply price filter.
        if ($request->get('inputMinPrice') || $request->get('inputMaxPrice')) {
            $auctions = $this->applyPriceFilter($request->get('inputMinPrice'), $request->get('inputMaxPrice'), $auctions);
        }

        // Apply distance filter.
        if ($authUser && $request->get('inputMaxDistance')) {
            $auctions = $this->applyDistanceFilter($auctions, $authUser, $request->get('inputMaxDistance'));
        }

        $data = [
            "category" => $category,
            "auctions" => $auctions,
            "filters" => [
                'minPrice' => $request->get('inputMinPrice'),
                'maxPrice' => $request->get('inputMaxPrice'),
                'maxDistance' => $request->get('inputMaxDistance')
            ]
        ];

        return view('category.view')->with($data);
    }

    public function categories()
    {
        $category = new Category();
        $category->id = null;
        $category->name = "Categorieën";
        $category->parent_id = null;

        $children = Category::allWhere("parent_id", $category->id);
        if (count($children))
            return self::categoryChildren($category, $children);

    }

    private function categoryChildren($category, $children)
    {
        $data = [
            "category" => $category,
            "children" => $children
        ];
        return view('category.children')->with($data);
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

    public function applyDistanceFilter(array $auctions, $user, $maxDistance)
    {
        $filteredAuctions = [];

        foreach ($auctions as $auction) {

            $seller = $auction->getSeller();

            if ($maxDistance > $this->getDistance($user->latitude, $user->longitude, $seller->latitude, $seller->longitude))
            {

                array_push($filteredAuctions, $auction);
            }
        }

        return $filteredAuctions;
    }

    function getDistance($lat1, $lon1, $lat2, $lon2)
    {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;
        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;
        //echo ' '.$km;
        return $km;
    }

}
