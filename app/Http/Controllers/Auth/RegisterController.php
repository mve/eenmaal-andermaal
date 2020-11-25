<?php

namespace App\Http\Controllers\Auth;

use App\DB;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\SendVerify;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Show the register form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'securityQuestions' => DB::select("SELECT * FROM security_questions")
        ];
        return view('auth.register')->with($data);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function create(Request $request)
    {
        $data = $request->all();

        if($data["verificatie_code"] == $request->session()->get('verify_code') ) {

            $this->validate($request, array(
                'username' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'],
                'first_name' => ['required', 'string'],
                'last_name' => ['required', 'string'],
                'address' => ['required', 'string'],
                'postal_code' => ['required', 'string'],
                'city' => ['required', 'string'],
                'country_code' => ['required', 'string'],
                'birth_date' => ['required', 'date_format:Y-m-d'],
                'security_question_id' => ['required'],
                'security_answer' => ['required', 'string']
            ));

            $user = new \App\User();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->address = $request->address;
            if ( !preg_match('/\s/',$request->postal_code) ) {
                $user->postal_code = chunk_split($request->postal_code, 4, ' ');
            } else {
                $user->postal_code = $request->postal_code;
            }
            $user->city = $request->city;
            $user->country_code = $request->country_code;
            $user->birth_date = $request->birth_date;
            $user->security_question_id = $request->security_question_id;
            $user->security_answer = $request->security_answer;
            $user->save();

            if($user->id==false)
                dd("fail");//TODO betere afhandeling

            // inloggen na registreren
            $request->session()->put('user', $user);

            return redirect('/');
        } else {
            return redirect('/registreren');
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function send_verify(Request $request)
    {

        $data = $request->all();

        if ($data["type"] == "1"){
            $code = Str::random(32);

            $request->verify_code = $code;
            $request->session()->put('verify_code', $code);

            Mail::to($data["email"])->send(new SendVerify($request));

            return response()->json(['success'=>'Vul de verificatie code in die gestuurd is naar je email']);
        }

        if ($data["type"] == "2") {

            if($data["code"] == $request->session()->get('verify_code') ) {

                return response()->json(['success'=>'Verificatie code is correct, Vul de rest van je gegevens in']);
            } else {

                return response()->json(['error'=>'Verificatie code is onjuist vul opnieuw in of vraag een nieuwe code aan']);
            }
        }

        //dd($request->session());
    }
}
