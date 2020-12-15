<?php

namespace App\Http\Controllers;

use App\Administrator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

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

        dd($request);
        //return view('admin.login');
    }


     /**
     * Show the login page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function loginView(Request $request)
    {

    
        return view('Admin.login');
    }

     /**
     * Show the login page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login(Request $request)
    {

        $admin = Administrator::oneWhere('email', $request->get('email'));

        if(!$admin){
            return redirect()->back()->withInput($request->all())->withErrors(["email" => "Ongeldige gegevens ingevuld"]);
        }

        $adminLoggedIn = Hash::check($request->get('password'), $admin->password);

        if ($adminLoggedIn) {
            $request->session()->put('admin', $admin);
            return redirect('/admin');
        }
        return redirect()->back()->withInput($request->all())->withErrors(["password" => "Ongeldige gegevens ingevuld"]);

    }

        
}
