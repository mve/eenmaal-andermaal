<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    /**
     * The session used by the guard.
     *
     * @var \Illuminate\Contracts\Session\Session
     */
    protected $session;

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Log the user in.
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $user = User::oneWhere('email', $request->get('email'), 'is_deleted', 0);

        if(!$user){
            return redirect()->back()->withInput($request->all())->withErrors(["email" => "Er is geen account gevonden met het ingevulde e-mailadres"]);
        }

        $userLoggedIn = Hash::check($request->get('password'), $user->password);

        if ($userLoggedIn) {
            $request->session()->put('user', $user);
            return redirect('/');
        }
        return redirect()->back()->withInput($request->all())->withErrors(["password" => "Incorrect wachtwoord ingevuld"]);
    }

    public function logout(Request $request)
    {
        if($request->session()->has('user')) {
            $request->session()->forget('user');
            $cookie = Cookie::forget("seller_verification");
            return redirect('login')->withCookie($cookie);
        }
    }
}
