<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

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
}
