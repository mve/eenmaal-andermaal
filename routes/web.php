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

Route::resource('auctions', AuctionController::class);
Route::get('mijnveilingen', 'AuctionController@myAuctions')->name('veilingen.mijn');
Route::get('gewonnenveilingen', 'AuctionController@wonAuctions')->name('veilingen.gewonnen');

Route::get('bid/{id}/{amount}', 'BidController@bid')->name('veilingen.bieden');
Route::get('bid/{id}', 'BidController@loadData')->name('veilingen.ophalen');

Route::get('/registreren', 'Auth\RegisterController@index')->name('register');
Route::post('/registreren', 'Auth\RegisterController@create');
Route::post('/registreren/verify', 'Auth\RegisterController@send_verify');


Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login');

Route::get('/wachtwoordvergeten', 'Auth\ForgotPasswordController@index')->name('wachtwoordvergeten');
Route::post('/wachtwoordvergeten', 'Auth\ForgotPasswordController@reset_mail');
Route::get('/wachtwoordvergeten/{token}', 'Auth\ForgotPasswordController@reset_password');
Route::post('/resetwachtwoord', 'Auth\ForgotPasswordController@update_password')->name('wachtwoordreset');

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('mijnaccount', 'UserDetailsController@index')->name('mijnaccount');
Route::get('mijnaccount/bewerken', 'UserDetailsController@edit')->name('mijnaccount.bewerken');
Route::post('mijnaccount/bewerken', 'UserDetailsController@update')->name('mijnaccount.bewerken');
Route::get('mijnaccount/phonefield/{id}', 'UserDetailsController@phoneField')->name('mijnaccount.phonefield');
Route::get('mijnaccount', 'UserDetailsController@index')->name('mijnaccount');

Route::get('verkoperworden', 'SellerVerificationController@verificationStart')->name('verkoperworden');
Route::post('verkoperworden', 'SellerVerificationController@verificationPost')->name('verkoperworden');
Route::get('verkoperworden/verifieren', 'SellerVerificationController@verificationVerify')->name('verkoperworden.verifieren');
Route::post('verkoperworden/verifieren', 'SellerVerificationController@verificationVerifyCheck')->name('verkoperworden.verifieren');

Route::get('/beoordeling/plaatsen/{id}','ReviewController@create')->name('beoordeling.toevoegen');
Route::post('/beoordeling/plaatsen/{id}','ReviewController@store')->name('beoordeling.toevoegen');

Route::get('faq', function () {
    return view('faq.faq');
});

Route::get('search', 'HomeController@search')->name('zoeken');
Route::post('search', 'HomeController@search')->name('zoeken');

Route::get('categorie/{id}', 'CategoryController@filtered')->name('auctionsInCategory');
Route::post('categorie/{id}', 'CategoryController@filtered')->name('auctionsInCategory');
Route::get('categorieën', 'CategoryController@categories')->name('categories');

//Route::get('foo', function () {
//    //Handmatige breadcrumbs voorbeeld
//    $data = [
//        "Appels",
//        "<a href='https://google.com'>Google</a>",
//        "Nederland",
//    ];
//    \App\Breadcrumbs::createAndPrint($data);
//    return "";
//});
