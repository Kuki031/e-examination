<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'getIndex'])->name('index');

Route::name("auth.")->group(function() {
    Route::get("/prijava", [AuthController::class, 'getLoginForm'])->name("login_form");
    Route::get("/registracija", [AuthController::class, 'getRegisterForm'])->name("register_form");
});

Route::name('users.')->group(function() {
    Route::get("/moj-profil", [UserController::class, 'getMyProfile'])->name('profile');
});
