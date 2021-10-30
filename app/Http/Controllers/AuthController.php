<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('Auth.login');
    }

    public function processlogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home');
        }

        return redirect()->route('login')->with('notifLogin', 'Email / Password Salah');
    }

    public function register()
    {
        return view('Auth.register');
    }

    public function processregister(Request $request)
    {

        $request->validate([
            'nomor_telp' => ['required', 'min:3', 'max:20'],
            'kota' => ['required', 'string', 'min:2', 'max:40'],
            'alamat' => ['required', 'string', 'min:2', 'max:120'],
            'postal_code' => ['required', 'string', 'min:2', 'max:20'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            ''
        ], [
            'name.required' => 'Nama Lengkap belum diisi!',
            'email.required' => 'Email belum diisi!',
            'email.unique' => 'Email sudah digunakan!',
            'password.required' => 'Password belum diisi!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.confirmed' => 'Password tidak sama!',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->alamat = $request->alamat;
        $user->kota = $request->kota;
        $user->postal_code = $request->postal_code;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->nomor_telp = $request->nomor_telp;
        $user->role = 'Seller';
        $user->save();

        return redirect()->route('login')->with('notifRegistration', 'Berhasil Terdaftar');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('dashboard');
    }
}
