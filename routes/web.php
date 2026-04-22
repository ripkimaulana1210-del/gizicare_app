<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PencatatanController;
use App\Http\Controllers\EdukasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| Protected Routes (Login Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // ✅ Dashboard berdasarkan role
    Route::get('/dashboard', function () {

        if (auth()->user()->role == 'admin') {
            return view('admin.dashboard');
        }

        return view('user.dashboard');
    })->name('dashboard');


    // ✅ Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // =====================================================
    // 🔥 PENCATATAN (FULL CRUD SIAP)
    // =====================================================

    Route::get('/pencatatan', [PencatatanController::class, 'index'])
        ->name('pencatatan.index');

    Route::post('/pencatatan', [PencatatanController::class, 'store'])
        ->name('pencatatan.store');
    Route::get('/pencatatan/{id}/edit', [PencatatanController::class, 'edit'])->name('pencatatan.edit');
    Route::put('/pencatatan/{id}', [PencatatanController::class, 'update'])->name('pencatatan.update');
    
    Route::delete('/pencatatan/{id}', [PencatatanController::class, 'destroy'])
        ->name('pencatatan.destroy');


    // =====================================================
    // 📚 EDUKASI
    // =====================================================

    Route::get('/edukasi', [EdukasiController::class, 'index'])
        ->name('edukasi.index');

    Route::get('/edukasi/create', [EdukasiController::class, 'create'])
        ->name('edukasi.create');

    Route::post('/edukasi', [EdukasiController::class, 'store'])
        ->name('edukasi.store');

    Route::get('/edukasi/{id}/edit', [EdukasiController::class, 'edit'])
        ->name('edukasi.edit');

    Route::put('/edukasi/{id}', [EdukasiController::class, 'update'])
        ->name('edukasi.update');

    Route::delete('/edukasi/{id}', [EdukasiController::class, 'destroy'])
        ->name('edukasi.destroy');


    // =====================================================
    // 🧪 DIAGNOSIS
    // =====================================================

    Route::get('/diagnosis', function () {
        return view('diagnosis.index');
    })->name('diagnosis');
});
