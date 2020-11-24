<?php

namespace App\Http\Controllers;

use App\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function show($id)
    {
        $auction = Auction::oneWhere("id", $id);
        if($auction===false)
            return abort(404);

        $auctionImages = $auction->getImages();
        $auctionBids = $auction->getBids();
        $negativeReviews = $auction->getNegativeReviews();
        $positiveReviews = $auction->getPositiveReviews();
        $auctionReviews = $auction->getReviews();
        $auctionReviewAverage = $auction->getReviewAverage();
        $auctionReviewsNegativePercent = round(($negativeReviews / count($auctionReviews))*100) ."%";
        $auctionReviewsPositivePercent = round(($positiveReviews / count($auctionReviews))*100) ."%";
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
