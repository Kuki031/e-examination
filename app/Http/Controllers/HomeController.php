<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getIndex()
    {
        return view('index');
    }

    public function getRegistrationSelector()
    {
        return view('auth.register_selector');
    }

    public function getLoginSelector()
    {
        return view('auth.login_selector');
    }
}
