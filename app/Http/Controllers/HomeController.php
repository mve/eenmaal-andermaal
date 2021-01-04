<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Category;
use App\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('check.user');
        $this->middleware('check.user.is.blocked');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
//        dump(request()->ip());
//        $user = session('user');
//        $binary = inet_pton('127.0.0.1');
//        dump(inet_ntop($binary));
//        dump($user->id);
//        dump(Carbon::now());

        $data = [
            "categoryMenuHTML" => Category::getCategories(),
            "popularAuctions" => Auction::getPopularAuctions(4),
            "personalAuctions" => Auction::getPersonalAuctions(3, 4),
            "topCategoryAuctions" => Auction::getAllTopCategoryAuctions(3)
        ];
        return view('home')->with($data);
    }

    public function search(Request $request){

        $auctions = array();

        if($request->keywords) {
            $keywords = explode(", ", $request->keywords);

        }

        if(isset($keywords)){
            foreach($keywords as $keyword) {
                $value = Auction::SearchAuctions($keyword);
                $auctions = array_merge($auctions, $value);
            }

            $data = [
                "keywords" => $keywords,
                "auctions" => array_unique($auctions, SORT_REGULAR)
            ];

            return view('search.view')->with($data);
        } else {
            return view('search.view');

        }

    }

    public function cookie(Request $request){
        if ($request->cookie_allow){
            return redirect()->back()->withCookie(cookie()->forever('cookie_allow', '1'));
        } else if  ($request->cookie_disallow){
            return redirect()->back()->withCookie(cookie()->forever('cookie_allow', '0'));
        } else {
            abort(404);
        }
      
    }


}
