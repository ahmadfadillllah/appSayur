<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function home()
    {
        return view('Admin.home');
    }

    public function produk()
    {
        $dataProduk = Product::all();
        return view('Admin.produk', ['dataProduk' => $dataProduk]);
    }

    public function processproduk(Request $request)
    {
        //dd($request->all());

        $produk = new Product();
        $produk->user_id = Auth::user()->id;
        $produk->name = $request->name;
        $produk->price = $request->price;
        $produk->description = $request->description;
        $produk->stock = $request->stock;
        $produk->location = $request->location;
        $file = $request->file('image');


        $nama_file = $file->getClientOriginalName();

        $tujuan_upload = 'img';
        $file->move($tujuan_upload,$nama_file);

        $produk->image = $nama_file;
        $produk->save();

        return redirect()->route('produk');
    }

    public function edit($id)
    {

        $produk = Product::find($id);

        return view('Admin.editproduk', ['produk' => $produk]);
    }

    public function update(Request $request, $id)
    {
        $produk = Product::find($id);
        $produk->update($request->all());

        return redirect()->route('produk')->with('notifeditProduk', 'Data Berhasil diubah!');
    }
}
