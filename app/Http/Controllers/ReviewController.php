<?php

namespace App\Http\Controllers;

use App\Auction;
use App\DB;
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
        $this->middleware('check.user.reviewed.auction')->except(['index']);
    }

    public function index()
    {
        $user_id = 2065;

        $data = DB::select("SELECT r.id AS review_id, r.auction_id, r.user_id, r.review_datetime, r.rating, r.comment, u.username, u.email, u.first_name, u.last_name, a.title AS auction_title, a.description AS auction_description
            FROM reviews r
            LEFT JOIN users u ON r.user_id = u.id
            LEFT JOIN auctions a ON r.auction_id = a.id
            WHERE r.user_id = " . $user_id);

        return view("reviews.index")->with('data', $data);
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
            'rating' => ['required', 'numeric', 'min:2', 'max:5'],
            'comment' => ['nullable', 'string', 'max:255'],
        ));

        $review = new Review();
        $review->auction_id = $request->get("auction")->id;
        $review->user_id = $request->session()->get("user")->id;
        $review->rating = $request->rating;
        if ($request->comment !== null)
            $review->comment = $request->comment;
        $review->save();
        $request->session()->flash('success', 'Beoordeling voor <b>' . $request->get("auction")->title . '</b> is geplaatst!');
        return redirect()->route('veilingen.gewonnen');
    }
}
