<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'getIndex'])->name('index');

Route::name("auth.")->prefix("autentifikacija")->group(function() {
    Route::get("/prijava", [AuthController::class, 'getStudentLoginForm'])->name("student_login_form");
    Route::get("/registracija", [AuthController::class, 'getStudentRegisterForm'])->name("student_register_form");
});

Route::name('users.')->prefix("korisnici")->group(function() {
    Route::get("/moj-profil", [UserController::class, 'getMyProfile'])->name('profile');
});
