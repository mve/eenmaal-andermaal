<?php

namespace App\Http\Controllers;

use App\Auction;
use App\AuctionCategory;
use App\AuctionHit;
use App\AuctionPaymentMethod;
use App\AuctionShippingMethod;
use App\Category;
use App\AuctionImage;
use App\Country;
use App\Mail\AuctionEnded;
use App\Mail\SellerVerification;
use App\PaymentMethod;
use App\ShippingMethod;
use App\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuctionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check.user')->except(['show', 'mailFinishedAuctionOwners']);
    }

    /**
     * Show the requested auction
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */

    public function create()
    {

        $data = [
            "mainCategories" => Category::allWhere("parent_id", -1),
            "shippingMethods" => ShippingMethod::all(),
            "paymentMethods" => PaymentMethod::all(),
            "countries" => Country::allOrderBy('country')
        ];
        return view("auctions.create")->with($data);

    }

    public function store(Request $request)
    {
        $this->validate($request, array(
            'title' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'start_price' => ['require', 'regex:/^\d+(\.\d{1,2})?$/'],
            'payment_instruction' => ['nullable', 'string', 'max:255'],
            'duration' => ['required', 'numeric'],
            'image.*' => ['required', 'mimes:jpeg,jpg,png', 'max:10000'],//10000kb/10mb
            'city' => ['required', 'string', 'max:100'],
        ));

        $catId = -1;
        foreach ($request->get("category") as $key => $value) {
            if ($value != -2) {
                $catId = $value;
            }
        }
        if (count(Category::allWhere("parent_id", $catId)))
            return redirect()->back()->withInput($request->all())->withErrors(["category" => "Je mag geen rubriek kiezen die zelf rubrieken heeft"]);
        if (
            $request->get("duration") != "1" &&
            $request->get("duration") != "3" &&
            $request->get("duration") != "5" &&
            $request->get("duration") != "7" &&
            $request->get("duration") != "10"
        )
            return redirect()->back()->withInput($request->all())->withErrors(["duration" => "Je mag alleen 1, 3, 5, 7 of 10 invullen"]);
        if (
            DB::selectOne("SELECT * FROM countries WHERE country_code=:country_code", [
                "country_code" => $request->countryCode
            ]) === false
        )
            return redirect()->back()->withInput($request->all())->withErrors(["countryCode" => "Er bestaat geen land in onze database met de ingevulde landcode"]);

        $auction = new Auction();
        $auction->user_id = $request->session()->get("user")->id;
        $auction->title = $request->title;
        $auction->description = $request->description;
        $auction->payment_instruction = $request->paymentInstruction;
        $auction->start_price = $request->startPrice;
        $auction->duration = $request->duration;
        $auction->end_datetime = Carbon::now()->addDays($auction->duration);
        $auction->city = $request->city;
        $auction->country_code = $request->countryCode;
        $auction->save();

        foreach ($request->file('image') as $img) {
            $fileName = $auction->id . "/" . Str::random(10) . ".png";
            if(env("APP_ENV")=="local"){
                Storage::disk('auction_images')->put($fileName, file_get_contents($img));
            }else{
                Storage::disk('auction_images_server')->put($fileName, file_get_contents($img));
            }

            $auctionImage = new AuctionImage();
            $auctionImage->auction_id = $auction->id;
            $auctionImage->file_name = '/images/auctions/' . $fileName;
            $auctionImage->save();
        }

        $auctionCategory = new AuctionCategory();
        $auctionCategory->auction_id = $auction->id;
        $auctionCategory->category_id = $catId;
        $auctionCategory->save();

        foreach ($request->shipping as $method) {
            $auctionShippingMethod = new AuctionShippingMethod();
            $auctionShippingMethod->auction_id = $auction->id;
            $auctionShippingMethod->shipping_id = $method;
            $auctionShippingMethod->save();
        }

        foreach ($request->payment as $method) {
            $auctionPaymentMethod = new AuctionPaymentMethod();
            $auctionPaymentMethod->auction_id = $auction->id;
            $auctionPaymentMethod->payment_id = $method;
            $auctionPaymentMethod->save();
        }

        return redirect()->route("auctions.show", $auction->id);
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
            "categories" => $cats,
            "selected" => false
        ];
        return view("includes.categoryselection")->with($data);
    }

    public function show($id)
    {
        $auction = Auction::oneWhere("id", $id);
        if ($auction === false)
            return abort(404);

        $user = session('user');
        AuctionHit::hit($auction, $user);

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
            "reviewsData" => $reviewsData,
            "auctionHits" => AuctionHit::getHits($auction)
        ];
        return view("auctions.view")->with($data);
    }

    function dateSortDesc($a, $b)
    {
        return strtotime($b) - strtotime($a);
    }

    /**
     * Get the user's auctions
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * Get the user's won auctions
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wonAuctions(Request $request)
    {
        $userId = Session::get("user")->id;
        $auctions = Auction::resultArrayToClassArray(DB::select("
                SELECT *
                FROM auctions
                WHERE GETDATE()>auctions.end_datetime AND EXISTS(
                    SELECT * FROM bids a WHERE auction_id=auctions.id AND user_id=$userId AND a.amount IN(
                        SELECT MAX(amount) FROM bids b GROUP BY auction_id
                    )
                )
            "));

        $data = [
            'auctions' => $auctions
        ];
        return view("auctions.wonauctions")->with($data);
    }

    /**
     * Send emails to owners of auctions finished within the last minute
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mailFinishedAuctionOwners()
    {
        $finishedAuctions = Auction::resultArrayToClassArray(DB::select("
                SELECT id,title,user_id
                FROM auctions
                WHERE auctions.end_datetime > DATEADD(MINUTE, -1, GETDATE()) AND auctions.end_datetime < GETDATE()
            "));
        foreach ($finishedAuctions as $auction) {
            Mail::to($auction->getSeller()->email)->send(new AuctionEnded($auction->title));
        }

        $endingAuctions = Auction::resultArrayToClassArray(DB::select("
                WITH finalInfo AS(
                    SELECT *
                    FROM bids
                    WHERE EXISTS(
                    SELECT bids.auction_id, bids.amount as amount
                        FROM bids bd
                        LEFT JOIN auctions
                        ON bids.auction_id=auctions.id
                        WHERE EXISTS (
                            SELECT auctions.id
                            FROM auctions
                            WHERE auctions.end_datetime > DATEADD(MINUTE, -1, DATEADD(MINUTE,10,GETDATE())) AND auctions.end_datetime < DATEADD(MINUTE,10,GETDATE()) AND bids.auction_id=auctions.id
                        )
                        AND bids.auction_id=bd.auction_id AND bids.amount=bd.amount
                    )
                )

                SELECT DISTINCT title,email
                    FROM (
                        SELECT auction_id,user_id,amount, Rank()
                          over (Partition BY auction_id
                                ORDER BY amount DESC ) AS Rank
                        FROM finalInfo
                        ) rs
                        LEFT JOIN auctions
                        ON auctions.id=rs.auction_id
                        LEFT JOIN users
                        ON users.id=rs.user_id
                        WHERE Rank <= 5
            "));
        dd($endingAuctions);
        foreach ($endingAuctions as $auction) {
            Mail::to($auction->getSeller()->email)->send(new AuctionEnded($auction->title));
        }


        $data = [
            'endingAuctionsCount' => count($endingAuctions),
            'finishedAuctionsCount' => count($finishedAuctions)
        ];
        return view("auctions.finishedauctions")->with($data);
    }
}
