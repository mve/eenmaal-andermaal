<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('auction', function () {
    return view('auctions.view');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('foo', function () {
//    return \Illuminate\Support\Facades\Hash::make("help");
//    return \App\User::login("stefanteunissen1@gmail.com", "help");
//   return \App\User::register("Stefan", "Teunissen", "ja@gmail.com", "HELP");

//    $user = \App\User::deleteWhere('name', "Pear");
//    dd($user);

    dd(\App\DB::select("INSERT INTO auction_hits (auction_id,user_id,ip_binary,hit_datetime) VALUES (:auction_id,:user_id,:ip_binary,:hit_datetime)",[
        "auction_id" => 0,
        "user_id" => 1,
        "ip_binary" => inet_ntop("192.168.0.0"),
//        "ip_binary" => "hey",
        "hit_datetime" => "2020-11-19 11:11:11"
    ]));

//    dd(\App\User::oneWhere("id",1));

    $user = new \App\User();
    $user->username = "appeltaart";
    $user->email = "appel@taart.nl";
    $user->password = \Illuminate\Support\Facades\Hash::make("xd");
    $user->first_name = "Appel";
    $user->last_name = "Taart";
    $user->address = "Straat 69";
    $user->postal_code = "6666XD";
    $user->city = "Taarten";
    $user->country = "Limburg";
    $user->birth_date = "2020-11-19";
    $user->security_question_id = 0;
    $user->security_answwer = "nee";
    $user->is_seller = 1;
    $user->is_admin = 1;
    $user->created_at = "2020-11-19 11:11:11";
    $user->save();
    dd($user);

//    $user = new \App\User();
//    $user->name = "APPLES";
//    $user->email = "asjidsakl@skdalj.com";
//    $user->password = \Illuminate\Support\Facades\Hash::make("xd");
//    $user->save();
//    dd($user);
});
