<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', 'DashboardController@index')->name('dashbaord');

//Login
Route::get('/login', 'AuthController@login')->name('login');
Route::post('/processlogin', 'AuthController@processlogin')->name('processlogin');


//Register
Route::get('/register', 'AuthController@register')->name('register');
Route::post('/processregister', 'AuthController@processregister')->name('processregister');

//Log Out
Route::get('/logout', 'AuthController@logout')->name('logout');


Route::group(['middleware' => 'auth'], function(){
    //Halaman Admin
    Route::get('/dashboard/home', 'AdminController@home')->name('home');

    //Halaman Produk
    Route::get('/dashboard/produk', 'AdminController@produk')->name('produk');
    Route::post('/dashboard/processproduk', 'AdminController@processproduk')->name('processProduk');

    Route::get('/dashboard/produk/{id}/edit', 'AdminController@edit')->name('editProduk');
    Route::post('/dashboard/produk/{id}', 'AdminController@update')->name('processEditProduk');

    //Halaman Profile
    Route::get('/dashboard/profile', 'ProfileController@profile')->name('profile');
});

