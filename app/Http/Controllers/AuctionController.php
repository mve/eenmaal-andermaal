<?php

namespace App\Http\Controllers;

use App\Auction;
use App\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check.user')->only(['myAuctions']);
    }

    /**
     * Show the requested auction
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function show($id)
    {
        $auction = Auction::oneWhere("id", $id);
        if ($auction === false)
            return abort(404);

        $auctionImages = $auction->getImages();
        $auctionBids = $auction->getBids();
        $auctionReviewCount = count($auction->getReviews());
        $reviewsData = [
            "count" => $auctionReviewCount,
            "average" => $auction->getReviewAverage(),
            "fiveStars" => number_format(($auctionReviewCount === 0 ? 0 : count($auction->getReviewsByRating(5)) / $auctionReviewCount) * 100) . "%",
            "fourStars" => number_format(($auctionReviewCount === 0 ? 0 : count($auction->getReviewsByRating(4)) / $auctionReviewCount) * 100) . "%",
            "threeStars" => number_format(($auctionReviewCount === 0 ? 0 : count($auction->getReviewsByRating(3)) / $auctionReviewCount) * 100) . "%",
            "twoStars" => number_format(($auctionReviewCount === 0 ? 0 : count($auction->getReviewsByRating(2)) / $auctionReviewCount) * 100) . "%",
            "oneStars" => number_format(($auctionReviewCount === 0 ? 0 : count($auction->getReviewsByRating(1)) / $auctionReviewCount) * 100) . "%"
        ];
        $data = [
            "auction" => $auction,
            "auctionImages" => $auctionImages,
            "auctionBids" => $auctionBids,
            "reviewsData" => $reviewsData
        ];
        return view("auctions.view")->with($data);
    }

    public function myAuctions(Request $request)
    {
        $myAuctions = Auction::resultArrayToClassArray(DB::select("SELECT * FROM auctions WHERE user_id=:user_id ORDER BY end_datetime ASC", [
            "user_id" => $request->session()->get("user")->id
        ]));
        $auctionsCount = count($myAuctions);
        $openAuctions = [];
        $closedAuctions = [];
        for ($i = 0; $i < $auctionsCount; $i++) {
            $parsedTime = Carbon::parse($myAuctions[$i]->end_datetime);
            if (Carbon::now() >= $parsedTime) {
                array_push($closedAuctions, $myAuctions[$i]);
            } else {
                array_push($openAuctions, $myAuctions[$i]);
            }
        }
        usort($closedAuctions, function ($a, $b) {
            return strtotime($b->end_datetime) - strtotime($a->end_datetime);
        });
        $allAuctions = [
            "openAuctions" => [
                "name" => "Mijn veilingen",
                "auctions" => $openAuctions
            ],
            "closedAuctions" => [
                "name" => "Gesloten veilingen",
                "auctions" => $closedAuctions
            ]
        ];
        $data = [
            "auctionsCount" => $auctionsCount,
            "allAuctions" => $allAuctions
        ];
        return view("auctions.myauctions")->with($data);
    }

    function dateSortDesc($a, $b) {
        return strtotime($b) - strtotime($a);
    }
}
