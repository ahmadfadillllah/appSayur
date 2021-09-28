<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $dataProduk = Product::all();
        return view('Dashboard.index', ['dataProduk' => $dataProduk]);
    }

    public function product()
    {
        $dataProduk = Product::all();

        return view('Dashboard.product', ['dataProduk' => $dataProduk]);
    }

    public function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
      }

    public function getLocation($lat, $lon)
    {
        // dd($lat, $lon);

        $dataProduk = Product::all();

        $match = [ ];

        foreach($dataProduk as $produk){
            $array = explode("|", $produk->location);

            $latproduk = $array[0];
            $lonproduk = $array[1];

            $hasil = $this->distance((float)$lat, (float)$lon, (float)$latproduk, (float)$lonproduk, "K");

            if($hasil > 400){
                $match[] = $produk;
            }
        }

        return json_encode($match);
    }

}
