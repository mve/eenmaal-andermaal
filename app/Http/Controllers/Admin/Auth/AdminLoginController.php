<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{

    /**
     * The session used by the guard.
     *
     * @var \Illuminate\Contracts\Session\Session
     */
    protected $session;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest.admin')->except('logout');
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin/login');
    }

    /**
     * Log the user in.
     *
     * @param Request $request
     * @return void
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
            return redirect('admin');
        }
        return redirect()->back()->withInput($request->all())->withErrors(["password" => "Ongeldige gegevens ingevuld"]);
    }

    public function logout(Request $request)
    {
        if($request->session()->has('admin')) {
            $request->session()->forget('admin');
            return redirect('admin/login');
        }
    }
}
