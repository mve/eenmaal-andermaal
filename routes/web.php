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

//    $user = new \App\User();
//    $user->name = "APPLES";
//    $user->email_address = "asjidsakl@skdalj.com";
//    $user->password = \Illuminate\Support\Facades\Hash::make("xd");
//    $user->save();
//    dd($user);
});
