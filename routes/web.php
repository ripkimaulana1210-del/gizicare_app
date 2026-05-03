<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PencatatanController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\DiagnosisController;

/*
|--------------------------------------------------------------------------
| Public Routes (No Login Required)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/quiz', [\App\Http\Controllers\QuizController::class, 'index'])->name('quiz.index');
Route::get('/quiz/start', [\App\Http\Controllers\QuizController::class, 'show'])->name('quiz.show');
Route::post('/quiz/submit', [\App\Http\Controllers\QuizController::class, 'submit'])->name('quiz.submit');

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Protected Routes (Login Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
    Route::get('/edukasi/{id}', [EdukasiController::class, 'show'])->name('edukasi.show');

    Route::get('/diagnosis', [DiagnosisController::class, 'index'])->name('diagnosis');
    Route::post('/diagnosis/session', [DiagnosisController::class, 'storeSession'])->name('diagnosis.session.store');
    Route::delete('/diagnosis/session/{session}', [DiagnosisController::class, 'destroySession'])->name('diagnosis.session.destroy');
    Route::post('/diagnosis/chat', [DiagnosisController::class, 'chat'])
        ->middleware('throttle:20,1')
        ->name('diagnosis.chat');

    Route::get('/pencatatan', [PencatatanController::class, 'index'])->name('pencatatan.index');
    Route::post('/pencatatan', [PencatatanController::class, 'store'])->name('pencatatan.store');
    Route::get('/pencatatan/{id}/edit', [PencatatanController::class, 'edit'])->name('pencatatan.edit');
    Route::put('/pencatatan/{id}', [PencatatanController::class, 'update'])->name('pencatatan.update');
    Route::delete('/pencatatan/{id}', [PencatatanController::class, 'destroy'])->name('pencatatan.destroy');
});
