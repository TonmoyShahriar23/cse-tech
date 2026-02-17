<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Registerwithotpcontroller extends Controller
{
    public function create()
    {
        return view('auth_otp.register');
    }
}
