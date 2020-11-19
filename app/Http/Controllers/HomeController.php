<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckUser;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware(CheckUser::class);
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

        return view('home');
    }
}
