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
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
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
            'name' => ['required','string'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','min:8','confirmed'],
            ''
        ],[
            'name.required' => 'Nama Lengkap belum diisi!',
            'email.required' => 'Email belum diisi!',
            'email.unique' => 'Email sudah digunakan!',
            'password.required' => 'Password belum diisi!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.confirmed' => 'Password tidak sama!',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
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
