<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Auction;
use App\DB;

class UserController extends Controller
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
    public function list()
    {
        $Auctions = User::getAuctionsByUser();

        $user = User::resultArrayToClassArray($Auctions);
        $data = [
            'users' => $user

        ];
        return view('admin.users.list')->with($data);
    }

    /**
     * Show the admin Dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function view(Request $request)
    {
        $user = User::oneWhere('id', $request->id);
        $auctions = Auction::resultArrayToClassArray(DB::select('SELECT title, end_datetime FROM auctions WHERE user_id =:user_id ORDER BY end_datetime DESC', [
            'user_id' => $user->id
        ]));

        $data = [
            'user' => $user,
            'auctions' => $auctions
        ];
        return view('admin.users.view')->with($data);
    }
}
