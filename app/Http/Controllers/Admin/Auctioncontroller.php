<?php

namespace App\Http\Controllers\Admin;

use App\DB;
use App\Auction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Auctioncontroller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check.admin');
    }

    public function list()
    {
        return view('admin.auctions.list');
    }

    public function view(Request $request)
    {
        $auction = Auction::oneWhere('id', $request->id);
        $auctionImages = $auction->getImages();

        $data = [
            'auction' => $auction,
            'auctionImages' => $auctionImages
        ];
        return view('admin.auctions.view')->with($data);
    }

    /**
     * @param Request $request
     * @return redirect to last page
     */
    public function toggleBlock(Request $request, $id)
    {
        $block = $request->has('unblock') ? 0 : 1;
        DB::insertOne('UPDATE auctions SET is_blocked =:block WHERE id =:id', ['block' => $block, 'id' => $id]);
        return redirect(url()->previous());
    }
}
