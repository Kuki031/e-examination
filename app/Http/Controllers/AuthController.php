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

    public function getTeacherLoginForm()
    {
        return view("auth.teacher_login");
    }

    public function getTeacherRegisterForm()
    {
        return view("auth.teacher_register");
    }
}
