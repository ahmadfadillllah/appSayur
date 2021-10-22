<?php

use App\Http\Controllers\DashboardController;
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

Route::get('/', 'DashboardController@index')->name('dashboard');
Route::get('/product', 'DashboardController@product')->name('product');
Route::get('/product/detail/{id}', 'DashboardController@showProduct')->name('product.detail');

Route::middleware(['auth'])->group(function () {

    Route::get('/product/checkout/{id}/{lat}/{lot}', 'DashboardController@checkoutPage')->name('product.checkout');

    Route::post('/product/checkout', 'DashboardController@checkout')->name('product.checkout.beli');

});

Route::get('/getLocation/{lat}/{lon}', 'DashboardController@getLocation')->name('getLocation');

//Login
Route::get('/login', 'AuthController@login')->name('login');
Route::post('/processlogin', 'AuthController@processlogin')->name('processlogin');

//Register
Route::get('/register', 'AuthController@register')->name('register');
Route::post('/processregister', 'AuthController@processregister')->name('processregister');

//Log Out
Route::get('/logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    //Halaman Admin
    Route::get('/dashboard/home', 'AdminController@home')->name('home');

    //Halaman Produk
    Route::get('/dashboard/produk', 'AdminController@produk')->name('produk');
    Route::post('/dashboard/processproduk', 'AdminController@processproduk')->name('processProduk');

    Route::get('/dashboard/produk/{id}/edit', 'AdminController@edit')->name('editProduk');
    Route::post('/dashboard/produk/{id}', 'AdminController@update')->name('processEditProduk');

    Route::get('/dashboard/produk/{id}/delete', 'AdminController@delete')->name('processDeleteProduk');

    //Halaman Profile
    Route::get('/dashboard/profile', 'ProfileController@profile')->name('profile');
});

Route::get('check/distance/{lat}/{lon}', function ($lat, $lon) {
    $lat2   =   0.6421855;
    $lon2   =   122.823442;

    $lat3   =   0.6486612;
    $lon3   =   122.8442952;

    $ds = new DashboardController;

    $r = $ds->distance($lat, $lon, $lat3, $lon3, 'K');

    dd(number_format($r, 3));
});
