<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PencatatanController;
use App\Http\Controllers\EdukasiController;

/*
|--------------------------------------------------------------------------
| Public Routes (No Login Required)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{id}', [EdukasiController::class, 'show'])->name('edukasi.show');

Route::get('/quiz', [\App\Http\Controllers\QuizController::class, 'index'])->name('quiz.index');
Route::get('/quiz/start', [\App\Http\Controllers\QuizController::class, 'show'])->name('quiz.show');
Route::post('/quiz/submit', [\App\Http\Controllers\QuizController::class, 'submit'])->name('quiz.submit');

Route::get('/diagnosis', function () {
    return view('diagnosis.index');
})->name('diagnosis');

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Protected Routes (Login Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pencatatan', [PencatatanController::class, 'index'])->name('pencatatan.index');
    Route::post('/pencatatan', [PencatatanController::class, 'store'])->name('pencatatan.store');
    Route::get('/pencatatan/{id}/edit', [PencatatanController::class, 'edit'])->name('pencatatan.edit');
    Route::put('/pencatatan/{id}', [PencatatanController::class, 'update'])->name('pencatatan.update');
    Route::delete('/pencatatan/{id}', [PencatatanController::class, 'destroy'])->name('pencatatan.destroy');
});
