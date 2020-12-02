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
        $auctionReviewCount = count($auction->getReviews());
        $reviewsData = [
            "count" => $auctionReviewCount,
            "average" => $auction->getReviewAverage(),
            "fiveStars" => number_format(($auctionReviewCount===0 ? 0 : count($auction->getReviewsByRating(5)) / $auctionReviewCount) * 100)."%",
            "fourStars" => number_format(($auctionReviewCount===0 ? 0 : count($auction->getReviewsByRating(4)) / $auctionReviewCount) * 100)."%",
            "threeStars" => number_format(($auctionReviewCount===0 ? 0 : count($auction->getReviewsByRating(3)) / $auctionReviewCount) * 100)."%",
            "twoStars" => number_format(($auctionReviewCount===0 ? 0 : count($auction->getReviewsByRating(2)) / $auctionReviewCount) * 100)."%",
            "oneStars" => number_format(($auctionReviewCount===0 ? 0 : count($auction->getReviewsByRating(1)) / $auctionReviewCount) * 100)."%"
        ];
        $data = [
            "auction" => $auction,
            "auctionImages" => $auctionImages,
            "auctionBids" => $auctionBids,
            "reviewsData" => $reviewsData
        ];
        return view("auctions.view")->with($data);
    }
}
