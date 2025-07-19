<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(private FlasherInterface $flasherInterface) {

    }
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

            $this->flasherInterface
            ->option('position', 'top-center')
            ->option('timeout', 2500)
            ->success(message: "Uspješno ste se prijavili u aplikaciju!", title: "Prijava uspješna");
            return to_route('index');
        }

        $this->flasherInterface
        ->option('position', 'top-center')
        ->option('timeout', 2500)
        ->error(message: "Netočni pristupni podaci!", title: "Prijava neuspješna");
        return back();
    }
}
