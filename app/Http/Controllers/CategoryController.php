<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Category;
use App\DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($id)
    {
        $category = Category::oneWhere("id", $id);

        $auctions = DB::select("SELECT a.id, a.title, a.description, a.start_price, a.payment_instruction, a.duration, a.end_datetime, a.city, a.country_code
            FROM auctions a
            LEFT JOIN auction_categories ac ON a.id = ac.auction_id WHERE ac.category_id = " . $category->id);

        $auctions = Auction::resultArrayToClassArray($auctions);

        $data = [
            "category" => $category,
            "auctions" => $auctions,
        ];

        return view('category.view')->with($data);
    }

    public function show($id)
    {
        $auction = Auction::oneWhere("id", $id);
        if ($auction === false)
            return abort(404);

        $auctionImages = $auction->getImages();
        $auctionBids = $auction->getBids();
        $negativeReviews = $auction->getNegativeReviews();
        $positiveReviews = $auction->getPositiveReviews();
        $auctionReviews = $auction->getReviews();
        $auctionReviewAverage = $auction->getReviewAverage();
        $auctionReviewsNegativePercent = (count($auctionReviews) > 0 ? round(($negativeReviews / count($auctionReviews)) * 100) : 0) . "%";
        $auctionReviewsPositivePercent = (count($auctionReviews) > 0 ? round(($positiveReviews / count($auctionReviews)) * 100) : 0) . "%";
        $data = [
            "auction" => $auction,
            "auctionImages" => $auctionImages,
            "auctionBids" => $auctionBids,
            "negativeReviews" => $negativeReviews,
            "positiveReviews" => $positiveReviews,
            "auctionReviews" => $auctionReviews,
            "auctionReviewAverage" => $auctionReviewAverage,
            "auctionReviewsNegativePercent" => $auctionReviewsNegativePercent,
            "auctionReviewsPositivePercent" => $auctionReviewsPositivePercent
        ];
        return view("auctions.view")->with($data);
    }
}
