<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Checkout;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{

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

    public function addToCart(Request $request)
    {
        try {

            $product_id =   $request->product_id;
            $qty        =   $request->qty;

            $product    =   Product::find($product_id);

            $user       =   (object) auth()->user();

            if (!$product)
                throw new \Exception('Produck dengan id ' . $product_id . ' Tidak ditemukan!');

            $cart    =   $user->cart()->where('product_id', '=', $product_id)->first();

            $cart['product_id'] =   $product_id;
            $cart['name']       =   $product->name;
            $cart['price']      =   $product->price;
            $cart['quantity']   =   $qty;

            if ($cart instanceof Cart) {
                $cart->update([
                    'price'     =>  $cart->price,
                    'quantity'  =>  $cart->quantity + 1,
                ]);
            } else {
                $user->cart()->create($cart);
            }

            return redirect()->back()->with('success', 'Produck dikeranjangkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('fail', $th->getMessage());
        }
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

        return view('Dashboard.product-card', [
            'products'  =>  $products,
            'laty'   =>  $lat,
            'lony'   =>  $lon,
        ]);
    }
}
