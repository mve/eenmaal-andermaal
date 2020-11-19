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

Route::get('/', 'HomeController@index')->name('home');

Route::get('auction', function () {
    return view('auctions.view');
});

Route::get('/register', 'Auth\RegisterController@index')->name('register');
Route::post('/register', 'Auth\RegisterController@create');


Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login');

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('foo', function () {
//    $user = \App\User::oneWhere("id",4);
//    $user->delete();

//    dd(\App\DB::select("INSERT INTO auction_hits (auction_id,user_id,ip,hit_datetime) VALUES (:auction_id,:user_id,:ip,:hit_datetime)",[
//        "auction_id" => 0,
//        "user_id" => 1,
////        "ip_binary" => inet_ntop("192.168.0.0"),
//        "ip" => "hey",
//        "hit_datetime" => \Carbon\Carbon::now()
//    ]));

    $hit = new \App\AuctionHit();
    $hit->auction_id = 0;
    $hit->user_id = 1;
    $hit->ip = "";
    $hit->hit_datetime = \Carbon\Carbon::now();
    $hit->save();
    dd($hit);

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
});
