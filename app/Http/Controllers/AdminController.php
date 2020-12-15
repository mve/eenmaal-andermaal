<?php

namespace App\Http\Controllers;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the admin Dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

    
        //return view('home')->with($data);
    }


     /**
     * Show the login page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login(Request $request)
    {

    
        //return view('home')->with($data);
    }

        
}
