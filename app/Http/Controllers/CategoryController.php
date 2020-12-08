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

        $data = [
            "category" => $category,
            "auctions" => $auctions,
            "filters" => [
                'minPrice' => $request->get('inputMinPrice'),
                'maxPrice' => $request->get('inputMaxPrice'),
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

}
