<?php

namespace App\Http\Controllers;

use App\Auction;
use App\auctionPaymentMethod;
use App\AuctionShippingMethod;
use App\Category;
use App\Country;
use App\PaymentMethod;
use App\ShippingMethod;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuctionController extends Controller
{

    public function create()
    {


        $data = [
            "mainCategories" => Category::allWhere("parent_id", -1),
            "shippingMethods" => ShippingMethod::all(),
            "paymentMethods" => PaymentMethod::all(),
            "countries" => Country::all()
        ];
        return view("auctions.create")->with($data);

    }

    public function store(Request $request)
    {
        $catId = -1;
        foreach ($request->get("category") as $key=>$value) {
            if($value!=-2){
                $catId=$value;
            }
        }
        if (count(Category::allWhere("parent_id", $catId)))
            return redirect()->back()->withInput($request->all())->withErrors(["category" => "Je mag geen rubriek kiezen die zelf rubrieken heeft"]);


        $auction = new Auction();
        $auction->user_id = $request->session()->get("user")->id;
        $auction->title = $request->inputTitle;
        $auction->description = $request->inputDescription;
        $auction->payment_instruction = $request->inputPaymentInstruction;
        $auction->start_price = $request->inputStartPrice;
        $auction->duration = $request->inputDuration;
        $auction->end_datetime = Carbon::now()->addDays($auction->duration);
        $auction->city = $request->inputCity;
        $auction->country_code = $request->inputCountryCode;
        $auction->save();


        foreach ($request->inputShipping as $method) {

            $auctionShippingMethod = new auctionShippingMethod();
            $auctionShippingMethod->auction_id = $auction->id;
            $auctionShippingMethod->shipping_id = $method;
            $auctionShippingMethod->save();
        }

        foreach ($request->inputPayment as $method) {

            $auctionPaymentMethod = new auctionPaymentMethod();
            $auctionPaymentMethod->auction_id = $auction->id;
            $auctionPaymentMethod->payment_id = $method;
            $auctionPaymentMethod->save();
        }


    }

    /**
     * Request new category select HTML
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categorySelect($id, $level)
    {
        $cats = Category::allWhere("parent_id", $id);
        if (count($cats) === 0)
            abort(404);

        $data = [
            "level" => $level,
            "categories" => $cats
        ];
        return view("includes.categoryselection")->with($data);
    }


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
}
