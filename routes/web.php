<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsAllowed;
use App\Http\Middleware\EnsureUserIsTeacherOrAdmin;
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
        Route::patch("/moj-profil/azuriraj-lozinku", [UserController::class, 'updatePassword'])->name("update_password");
});


// Admin rute
Route::middleware(['auth', EnsureUserIsAdmin::class])->prefix("administrator")->name("admin.")->group(function() {
    Route::get("/korisnici", [AdminController::class, 'getAllUsers'])->name("new_users_list");
    Route::get("/korisnici/{user}", [AdminController::class, 'getUserProfile'])->name("user_profile");
    Route::get("/zahtjevi/brojka", [AdminController::class, 'countRequests'])->name("request_count");
    Route::post("/zahtjevi/{user}/odbij", [AdminController::class, 'rejectRegistration'])->name("reject_registration");
    Route::post("/zahtjevi/{user}/odobri", [AdminController::class, 'approveRegistration'])->name("approve_registration");
    Route::patch("/korisnici/{user}/dodjeli-ulogu", [AdminController::class, 'assignRole'])->name("assign_role");
    Route::delete("/korisnici/{user}/obrisi", [AdminController::class, "deleteUser"])->name("delete_user");

});

// Provedba ispita, rute za nastavnika ili admina (jer admin može biti i nastavnik)
Route::middleware(['auth', EnsureUserIsTeacherOrAdmin::class])->prefix("nastavnik")->name("teacher.")->group(function() {
    Route::get("/nova-provjera-znanja", [ExamController::class, 'getCreateForm'])->name("new_exam");
    Route::post("/nova-provjera-znanja", [ExamController::class, 'createExam'])->name("create_exam");
    Route::get("/moje-provjere-znanja", [ExamController::class, 'getMyExams'])->name("teacher_exams");
    Route::get("/provjera-znanja/{exam}/kreiraj-pitanja", [ExamController::class, 'getQuestionMakerForExam'])->name("create_questions");
    Route::get("/provjera-znanja/{exam}", [ExamController::class, 'getExamDetails'])->name("exam_details");
    Route::patch("/provjera-znanja/{exam}", [ExamController::class, 'updateExam'])->name("update_exam");
    Route::post("/provjera-znanja/{exam}/spremi-pitanja", [QuestionController::class, 'saveQuestions'])->name("save_questions");
    Route::get("/provjera-znanja/{exam}/pitanja", [QuestionController::class, 'getQuestionsForExam'])->name("exam_question_list");
    Route::get("/provjera-znanja/{exam}/pitanja/{question}", [QuestionController::class, 'getQuestionDetails'])->name("exam_question_details");
    Route::patch("/provjera-znanja/{exam}/pitanja/{question}", [QuestionController::class, 'updateQuestion'])->name("exam_question_update");
    Route::delete("/provjera-znanja/{exam}/pitanja/{question}", [QuestionController::class, 'deleteQuestion'])->name("exam_question_delete");

});



Route::fallback([HomeController::class, 'fallbackRoute']);
