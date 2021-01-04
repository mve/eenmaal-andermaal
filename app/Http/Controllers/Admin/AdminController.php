<?php

namespace App\Http\Controllers\Admin;

use App\Auction;
use App\Category;
use App\User;
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
        $data = User::getCreatedUsersLastMonth();
        $total = [];
        $created_at = [];

        foreach ($data as $dateWithUserCount)
        {
            array_push($total, $dateWithUserCount['total']);
            array_push($created_at, $dateWithUserCount['created_at']);
        }

        $data = [
            "total" => $total,
            "created_at" => $created_at
        ];

        return view('admin.index')->with($data);
    }
}
