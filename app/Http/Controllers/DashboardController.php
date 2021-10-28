<?php

namespace App\Http\Controllers;

use App\Checkout;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Crypt;
use Midtrans\Config;

class DashboardController extends Controller
{
    public $merchant_id = 'G805780044';
    public $client_id = 'SB-Mid-client-YCHtULs46ydSA7tV';
    public $server_key = 'SB-Mid-server-5aQABsAA0KihdYoBHSk1kgPy';

    public function index()
    {
        $dataProduk = Product::all();

        return view('Dashboard.index', ['dataProduk' => $dataProduk]);
    }

    public function product()
    {
        return view('Dashboard.product');
    }

    public function showProduct()
    {
        dd('test');
    }

    public function checkoutPage(string $id, $lat, $lon)
    {
        $product    =   Product::find($id);
        $onkir      =   00;

        if (!$product) redirect()->back();

        if (($product instanceof Product) === false) redirect()->back();

        $cordinate = explode("|", $product->location);

        $qty    =   request('qty') ?? 1;

        if ($qty >= $product->stock) {
            $qty = $product->stock;
        }

        $lat_p = $cordinate[0];
        $lon_p = $cordinate[1];

        $distance   =   $this->distance($lat, $lon, $lat_p, $lon_p, "K");

        if ($distance >= 0 && $distance <= 1.0) {
            $onkir  =   1000;
        } else if ($distance  > 1.0 && $distance <= 2.0) {
            $onkir  =   2000;
        } else if ($distance  > 2.0 && $distance <= 3.0) {
            $onkir  =   3000;
        } else if ($distance  > 3.0 && $distance <= 4.0) {
            $onkir  =   4000;
        } else if ($distance  > 4.0 && $distance <= 5.0) {
            $onkir  =   5000;
        } else {
            $onkir  =   6000;
        }

        $user = (object) auth()->user();

        $checkout_fake = factory(Checkout::class)->make([
            'onkir'     =>  $onkir,
            'lat_lon'   =>  "$lat|$lon",
            'qty'       =>  $qty,
            'pembeli_id'    =>  $user->id,
            'product_id'    =>  $product->id,
        ]);

        return view('Dashboard.product-checkout', [
            'product'   =>  $product,
            'onkir'     =>  $onkir,
            'user'      =>  $user,
            'lat'       =>  $lat,
            'lon'       =>  $lon,
            'qty'       =>  $qty,
            'fake'      =>  $checkout_fake,
        ]);
    }

    public function checkout(Request $request)
    {
        if (!auth()->check()) return redirect()->back();

        $request->validate([
            'email'         =>  ['required', 'email'],
            'first_name'    =>  ['required', 'min:3', 'max:20'],
            'last_name'     =>  ['required', 'min:3', 'max:20'],
            'nomor_telp'    =>  ['required', 'min:4', 'max:20'],
            'city'          =>  ['required', 'min:2', 'max:20'],
            'postal_code'   =>  ['required', 'min:2', 'max:10'],
            'lat_lon'       =>  ['required'],
            'note'          =>  ['nullable'],
            'alamat'        =>  ['required', 'string'],
            'product_id'    =>  ['required', 'integer'],
            'qty'           =>  ['required', 'integer'],
            'onkir'         =>  ['required', 'integer'],
            'total_harga'   =>  ['required', 'integer'],
        ]);

        $product    =   Product::find($request->product_id);

        $user       =   (object) auth()->user();

        $order_id   =   $this->randId(uniqid($request->product_id));

        $chekout = Checkout::create([
            'order_id'      =>  $order_id,
            'first_name'    =>  $request->first_name,
            'last_name'     =>  $request->last_name,
            'city'          =>  $request->city,
            'postal_code'   =>  $request->postal_code,
            'nomor_telp'    =>  $request->nomor_telp,
            'status'        =>  0,
            'catatan'       =>  $request->note,
            'alamat_tujuan' =>  $request->alamat,
            'email'         =>  $request->email,
            'product_id'    =>  $product->id,
            'qty'           =>  $request->qty,
            'onkir'         =>  $request->onkir,
            'harga_produk'  =>  $product->price,
            'pembeli_id'    =>  $user->id,
            'penjual_id'    =>  $product->user_id,
            'lat_lon'       =>  $request->lat_lon,
            'expired_at'    =>  now()->addDay(),
            'total_transaksi' =>  $request->total_harga,
            'metode_pembayaran' => 'none',
        ]);

        $snapToken = $this->midtrans($request, $product, $chekout, $order_id);

        return redirect()->route('product.pay', [$chekout->id, Crypt::encrypt($snapToken)]);
    }

    private function midtrans(Request $request, Product $product, Checkout $checkout, $order_id)
    {
        // Set your Merchant Server Key
        Config::$serverKey = $this->server_key;
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = false;
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;

        $user       =   (object) auth()->user();

        $params = [
            'transaction_details' => [
                'order_id'      =>  $order_id,
                'gross_amount'  =>  $request->total_harga,
            ],
            'customer_details' => [
                'first_name' =>  $request->first_name,
                'last_name' =>  $request->last_name,
                'email'     =>  $user->email,
                'phone'     =>  $request->nomor_telp,
                "billing_address"   =>  [
                    "first_name"    =>  $user->name,
                    "last_name"     =>  "",
                    "email"         =>  $user->email,
                    "phone"         =>  "08123456789",
                    "address"       =>  "Sudirman No.12",
                    "city"          =>  "Makassar",
                    "postal_code"   =>  "12190",
                    "country_code"  =>  "IDN"
                ],
                "shipping_address"  =>  [
                    "first_name"    =>  $request->first_name,
                    "last_name"     =>  $request->last_name,
                    "email"         =>  $request->email,
                    "phone"         =>  $request->nomor_telp,
                    "address"       =>  $request->alamat,
                    "city"          =>  $request->city,
                    "postal_code"   =>  $request->postal_code,
                    "country_code"  =>  "IDN"
                ],
            ],
            'item_details'  =>  [
                [
                    'id'    =>   $this->randId($product->id),
                    'name'  =>  $product->name,
                    'price' =>  $product->price,
                    'quantity'  =>  $request->qty,
                ],
                [
                    'id'    =>   $this->randId($product->id),
                    'name'  =>  'Onkos kirim',
                    'price' =>  $checkout->onkir,
                    'quantity'  =>  1,
                ]
            ],
        ];

        return \Midtrans\Snap::getSnapToken($params);
    }

    private function randId(string $suffix): string
    {
        $words = ['a', 'b', 'c', 'd', 'f', 'x', 'k', 'p', 'z'];
        return strtoupper($words[rand(0, count($words) - 1)] . rand(0, 9) . "$suffix");
    }

    public function productPay($id, $token)
    {
        $snap_token =   Crypt::decrypt($token);

        $checkout   =   Checkout::find($id);

        return view('Dashboard.product-pay', [
            'checkout'      =>  $checkout,
            'product'       =>  $checkout->product,
            'snap_token'    =>  $snap_token,
        ]);
    }

    public function transactionSuccess() {
        dd(request());
    }


    public function distance(float $lat1, float $lon1, float $lat2, float $lon2, $unit)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);

        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            $miles = ($miles * 1.609344);
        } else if ($unit == "N") {
            $miles = ($miles * 0.8684);
        }

        return (float) $miles;
    }

    public function getLocation($lat, $lon)
    {
        // dd($lat, $lon);

        $dataProduk = Product::all();

        $products = [];

        foreach ($dataProduk as $produk) {
            $array = explode("|", $produk->location);

            $latproduk = $array[0];
            $lonproduk = $array[1];

            $hasil = $this->distance((float)$lat, (float)$lon, (float)$latproduk, (float)$lonproduk, "K");

            if (intval($hasil) < 5.00) {
                $products[] = $produk;
            }
        }

        // dump($products);

        return view('Dashboard.product-card', [
            'products'  =>  $products,
            'laty'   =>  $lat,
            'lony'   =>  $lon,
        ]);
    }
}
