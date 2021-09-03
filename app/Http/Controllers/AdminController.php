<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home()
    {
        return view('Admin.home');
    }

    public function produk()
    {
        return view('Admin.produk');
    }
}
