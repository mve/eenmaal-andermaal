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
Route::get('veilingen/af/mail', 'AuctionController@mailFinishedAuctionOwners')->name('veilingen.mailsturen');

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
Route::post('mijnaccount/verwijderen', 'UserDetailsController@remove')->name('mijnaccount.verwijderen');
Route::get('mijnaccount/phonefield/{id}', 'UserDetailsController@phoneField')->name('mijnaccount.phonefield');
Route::get('mijnaccount', 'UserDetailsController@index')->name('mijnaccount');

Route::get('verkoperworden', 'SellerVerificationController@verificationStart')->name('verkoperworden');
Route::post('verkoperworden', 'SellerVerificationController@verificationPost')->name('verkoperworden');
Route::get('verkoperworden/verifieren', 'SellerVerificationController@verificationVerify')->name('verkoperworden.verifieren');
Route::post('verkoperworden/verifieren', 'SellerVerificationController@verificationVerifyCheck')->name('verkoperworden.verifieren');

Route::get('/beoordeling', 'ReviewController@index')->name('beoordeling.overzicht');
Route::get('/beoordeling/plaatsen/{id}', 'ReviewController@create')->name('beoordeling.toevoegen');
Route::post('/beoordeling/plaatsen/{id}', 'ReviewController@store')->name('beoordeling.toevoegen');

Route::get('faq', function () {
    return view('faq.faq');
});

Route::get('categorie/{id}', 'CategoryController@index')->name('auctionsInCategory');

Route::get('/veilingmaken', 'AuctionController@create')->name('veilingmaken')->middleware('check.user.seller');
Route::get('veilingmaken/categoryselect/{id}/{level}/', 'AuctionController@categorySelect')->name('veilingmaken.categoryselect');

Route::get('search', 'HomeController@search')->name('zoeken');
//Route::post('search', 'HomeController@search')->name('zoeken');

Route::get('categorie/{id}', 'CategoryController@filtered')->name('auctionsInCategory');
Route::post('categorie/{id}', 'CategoryController@filtered')->name('auctionsInCategory');
Route::get('categorieën', 'CategoryController@categories')->name('categories');

Route::get('cookie', 'HomeController@cookie')->name('cookie');
Route::post('cookie', 'HomeController@cookie')->name('cookie');

Route::get('privacy', 'HomeController@privacy')->name('privacy');

// Admin Routes
Route::get('admin', 'Admin\AdminController@index')->name('Admin.Index');
Route::get('admin/login', 'Admin\Auth\AdminLoginController@index')->name('Admin.login');
Route::post('admin/logout', 'Admin\Auth\AdminLoginController@logout')->name('Admin.logout');
Route::post('admin/login', 'Admin\Auth\AdminLoginController@login')->name('Admin.login');

Route::get('admin/users', 'Admin\UserController@list')->name('admin.users.list');
Route::get('admin/users/{id}', 'Admin\UserController@view')->name('admin.users.view');
Route::post('admin/users/{id}', 'Admin\UserController@toggleBlock');
Route::get('admin/auctions', 'Admin\AuctionController@list')->name('admin.auctions.list');
Route::get('admin/auctions/{id}', 'Admin\AuctionController@view')->name('admin.auctions.view');
Route::post('admin/auctions/{id}', 'Admin\AuctionController@toggleBlock');
Route::post('admin/auctions/{id}/edit/save', 'Admin\AuctionController@save')->name('admin.auctions.edit.save');
Route::match(array('GET', 'POST'), 'admin/auctions/{id}/edit', 'Admin\AuctionController@edit')->name('admin.auctions.edit');

Route::get('admin/statistics', 'Admin\AdminController@statistics')->name('admin.statistics');

Route::resource('admin/categories', Admin\CategoryController::class);



//Route::get('foo', function () {
//    // Handmatige breadcrumbs voorbeeld
//    $data = [
//        "Appels",
//        "<a href='https://google.com'>Google</a>",
//        "Nederland",
//    ];
//    \App\Breadcrumbs::createAndPrint($data);
//    return "";
//});
