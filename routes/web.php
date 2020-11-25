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

Route::get('/registreren', 'Auth\RegisterController@index')->name('register');
Route::post('/registreren', 'Auth\RegisterController@create');
Route::post('/registreren/verify', 'Auth\RegisterController@send_verify');


Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login');

Route::get('/wachtwoordvergeten', 'Auth\ForgotPasswordController@index')->name('wachtwoordvergeten');
Route::post('/wachtwoordvergeten', 'Auth\ForgotPasswordController@reset_mail');
Route::get('/wachtwoordvergeten/{token}', 'Auth\ForgotPasswordController@reset_password');

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('foo', function () {
//    $user = \App\User::oneWhere("id",4);
//    $user->delete();

    //Handmatig rij toevoegen en true/false krijgen
    dd(\App\DB::insertOne("INSERT INTO auction_hits (auction_id,user_id,ip,hit_datetime) VALUES (:auction_id,:user_id,:ip,:hit_datetime)",[
        "auction_id" => 0,
        "user_id" => 1,
//        "ip_binary" => inet_ntop("192.168.0.0"),
        "ip" => "hey",
        "hit_datetime" => \Carbon\Carbon::now()
    ]));

    //Handmatig rij toevoegen en ID krijgen
    dd(\App\DB::selectOne("INSERT INTO auction_hits (auction_id,user_id,ip,hit_datetime) OUTPUT Inserted.id VALUES (:auction_id,:user_id,:ip,:hit_datetime)",[
        "auction_id" => 0,
        "user_id" => 1,
//        "ip_binary" => inet_ntop("192.168.0.0"),
        "ip" => "hey",
        "hit_datetime" => \Carbon\Carbon::now()
    ]));

//    dd(\App\AuctionHit::oneWhere("id",203));

//    $hit = new \App\AuctionHit();
//    $hit->auction_id = 0;
//    $hit->user_id = 1;
////    $hit->ip = inet_ntop("192.168.1.1");
//    $hit->ip = "192.168.2.7";
//    $hit->hit_datetime = \Carbon\Carbon::now();
//    $hit->save();
//    dd($hit);

//    $user = \App\User::allWhere("username","s");
//    dd($user);

//    $user = new \App\User();
//    $user->username = "appeltaart";
//    $user->email = "appel@taart.nl";
//    $user->password = \Illuminate\Support\Facades\Hash::make("xd");
//    $user->first_name = "Appel";
//    $user->last_name = "Taart";
//    $user->address = "Straat 69";
//    $user->postal_code = "6666XD";
//    $user->city = "Taarten";
//    $user->country = "Limburg";
//    $user->birth_date = "2020-11-19";
//    $user->security_question_id = 0;
//    $user->security_answer = "nee";
//    $user->is_seller = 1;
//    $user->is_admin = 1;
//    $user->created_at = \Carbon\Carbon::now();
//    $user->save();
//    dd($user);
});
