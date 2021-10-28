<?php

use App\Http\Controllers\DashboardController;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Artisan;
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

    Route::get('/product/order/{id}/{lat}/{lot}', 'DashboardController@checkoutPage')->name('product.checkout');

    Route::post('/product/checkout', 'DashboardController@checkout')->name('product.checkout.beli');

    Route::get('/product/pay/{id}/{token}', 'DashboardController@productPay')->name('product.pay');

    Route::get('/transaction/success', 'DashboardController@transactionSuccess');

    Route::get('/transaction/fail', function () {
        dd('unfinish', request());
    });

    Route::get('/transaction/error', function () {
        dd('error', request());
    });

    Route::get('notification', function () {
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$serverKey = '<your serverkey>';
        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    echo "Transaction order_id: " . $order_id . " is challenged by FDS";
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            echo "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
        }
    });
});

Route::get('/generate-dumy-data/{amount}', function ($amount) {
    $user = factory(User::class)->create();
    $r = factory(Product::class, $amount)->create();
    dd($user, $r);
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
