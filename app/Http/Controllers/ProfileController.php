<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
        $datauser = User::all()->first();
        return view('Profile.index', ['datauser' => $datauser]);
    }
}
