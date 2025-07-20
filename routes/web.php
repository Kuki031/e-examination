<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsAllowed;
use Illuminate\Support\Facades\Route;

// Redirect sa root-a
Route::get('/', function () {
    return redirect("/naslovnica");
});

Route::get('/naslovnica', [HomeController::class, 'getIndex'])->name('index');


Route::name("auth.")->prefix("autentifikacija")->group(function() {

    Route::get("/prijava", [HomeController::class, 'getLoginSelector'])->name("login_selector");
    Route::get("/registracija", [HomeController::class, 'getRegistrationSelector'])->name("register_selector");
    Route::get("/prijava/student", [AuthController::class, 'getStudentLoginForm'])->name("student_login_form");
    Route::get("/registracija/student", [AuthController::class, 'getStudentRegisterForm'])->name("student_register_form");
    Route::get("/prijava/nastavnik", [AuthController::class, "getTeacherLoginForm"])->name("teacher_login_form");

    Route::get("/registracija/nastavnik", [AuthController::class, "getTeacherRegisterForm"])->name("teacher_register_form");

    Route::middleware([EnsureUserIsAllowed::class])->group(function() {
        Route::post("/prijava", [AuthController::class, 'authenticate'])->name("login");
    });

    Route::post("/registracija", [AuthController::class, 'register'])->name('register');
    Route::middleware(['auth'])->group(function() {
        Route::post("/odjavi-se", [AuthController::class, 'logout'])->name("logout");
    });
});

Route::middleware(['auth'])
    ->name('users.')->prefix("korisnici")
    ->group(function() {
        Route::get("/moj-profil", [UserController::class, 'getMyProfile'])->name('profile');
});


Route::fallback([HomeController::class, 'fallbackRoute']);
