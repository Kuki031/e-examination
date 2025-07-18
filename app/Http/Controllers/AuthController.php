<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function getStudentLoginForm()
    {
        return view("auth.student_login");
    }

    public function getStudentRegisterForm()
    {
        return view("auth.student_register");
    }
}
