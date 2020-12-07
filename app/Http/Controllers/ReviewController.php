<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check.user.reviewed.auction');
    }

    public function create(Request $request)
    {
        $auction = $request->get("auction");
        $data = [
            "auction" => $auction,
            "seller" => $auction->getSeller()
        ];
        return view("reviews.create")->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, array(
            'rating' => ['required', 'numeric','min:2', 'max:5'],
            'comment' => ['nullable','string', 'max:255'],
        ));

        $review = new Review();
        $review->auction_id = $request->get("auction")->id;
        $review->user_id = $request->session()->get("user")->id;
        $review->rating = $request->rating;
        if($request->comment!==null)
            $review->comment = $request->comment;
        $review->save();
        return redirect()->route('auctions.show',$request->get("auction")->id);
    }
}
