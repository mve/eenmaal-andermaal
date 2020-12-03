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

    public function filtered($id, Request $request)
    {

        dd($request);

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
}
