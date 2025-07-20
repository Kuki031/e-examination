<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use App\Traits\ToastInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    use ToastInterface;

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

    public function authenticate(AuthenticateRequest $authenticateRequest)
    {

        if (Auth::attempt($authenticateRequest->validated())) {
            $authenticateRequest->session()->regenerate();
            $this->constructToastMessage("Uspješno ste se prijavili u aplikaciju!", "Prijava uspješna", "success");

            return to_route("index");
        }

        $this->constructToastMessage("Netočni pristupni podaci!", "Prijava neuspješna", "error");
        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $this->constructToastMessage("Uspješno ste se odjavili iz aplikacije!", "Odjava uspješna", "success");
        return to_route("index");
    }
}
