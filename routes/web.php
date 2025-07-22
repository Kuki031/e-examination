<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsAllowed;
use Illuminate\Support\Facades\Route;

// Redirect sa root-a
Route::get('/', function () {
    return redirect("/naslovnica");
});

Route::get('/naslovnica', [HomeController::class, 'getIndex'])->name('index');


// Autentifikacija rute
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


// Korisnici rute
Route::middleware(['auth'])
    ->name('users.')->prefix("korisnici")
    ->group(function() {
        Route::get("/moj-profil", [UserController::class, 'getMyProfile'])->name('profile');
        Route::patch("/moj-profil/azuriraj", [UserController::class, 'editProfile'])->name("edit_profile");
});


// Admin rute
Route::middleware(['auth', EnsureUserIsAdmin::class])->prefix("administrator")->name("admin.")->group(function() {
    Route::get("/zahtjevi", [AdminController::class, 'getNewlyRegisteredUsers'])->name("new_users_list");
    Route::get("/zahtjevi/brojka", [AdminController::class, 'countRequests'])->name("request_count");
    Route::post("/zahtjevi/{user}/odbij", [AdminController::class, 'rejectRegistration'])->name("reject_registration");
    Route::post("/zahtjevi/{user}/odobri", [AdminController::class, 'approveRegistration'])->name("approve_registration");
});


Route::fallback([HomeController::class, 'fallbackRoute']);
