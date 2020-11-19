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
//    return \Illuminate\Support\Facades\Hash::make("help");
//    return \App\User::login("stefanteunissen1@gmail.com", "help");
//   return \App\User::register("Stefan", "Teunissen", "ja@gmail.com", "HELP");

    $user = \App\User::oneWhere("id",4);
    $user->delete();

    // $users = \App\User::allWhere("email", "asjidsakl@skdalj.com");
    // foreach($users as $user){
    //     $user->delete();
    // }
    // $users = \App\User::allWhere("email", "asjidsakl@skdalj.com");
    // dd($users);

//    $user = new \App\User();
//    $user->name = "APPLES";
//    $user->email = "asjidsakl@skdalj.com";
//    $user->password = \Illuminate\Support\Facades\Hash::make("xd");
//    $user->save();
//    dd($user);
});
