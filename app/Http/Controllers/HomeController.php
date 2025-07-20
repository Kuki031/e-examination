<?php

namespace App\Http\Controllers;

use App\Traits\ToastInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    use ToastInterface;
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

    public function fallbackRoute()
    {
        $this->constructToastMessage("Tražena stranica ne postoji. Prebačeni ste na naslovnicu.", "Nepostojeća stranica", "warning");
        return redirect("/naslovnica");
    }
}
