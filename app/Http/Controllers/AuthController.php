<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ToastInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\String\b;

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
            $this->constructToastMessage(message: "Uspješno ste se prijavili u aplikaciju!", title: "Prijava uspješna", model: "success");

            return to_route("index");
        }

        $this->constructToastMessage(message: "Netočni pristupni podaci!", title: "Prijava neuspješna", model: "error");
        return back();
    }

    public function register(RegisterRequest $registerRequest)
    {
        $data = NULL;

        if ($registerRequest['pin'] === 'JMBAG')
        {
            $data = $registerRequest->validated();
            $data['registration_type'] = 'student';
            $data['role'] = 'student';

        } else if ($registerRequest['pin'] === 'OIB') {

            $data = $registerRequest->validated();
            $data['registration_type'] = 'teacher';
            $data['role'] = 'student';
        }

        $user = User::create($data);

        if ($user) {
            $this->constructToastMessage(message: "Uspješno ste se registrirali u aplikaciju! Kako bi ste mogli koristiti sve značajke aplikacije, administrator mora odobriti vašu prijavu.", title: "Registracija uspješna", model: "success", timeout: 5000);
            return to_route("index");
        }
        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $this->constructToastMessage(message: "Uspješno ste se odjavili iz aplikacije!", title: "Odjava uspješna", model: "success");
        return to_route("index");
    }
}
