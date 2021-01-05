<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
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

    /**
     * Show the admin Dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('admin.index');
    }        

    // -- Totaal geboden bedrag ophalen voor alle veilingen (alleen laatste biedingen)
    // SELECT ISNULL(SUM(amount), 0) 
	// FROM bids b INNER JOIN 
	// (SELECT auction_id, max(amount) as maxAmount FROM bids GROUP BY auction_id) bm 
	// ON b.auction_id = bm.auction_id AND b.amount = bm.maxAmount 
}
