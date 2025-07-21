<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\FuzzyTopsisController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\DataNormalisasiController;

// Redirect ke login saat akses root
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Route hanya untuk user login
Route::middleware('auth')->group(function () {
    /**
     * Route VIEW bersama (bisa diakses admin dan user)
     */
Route::get('/data-normalisasi', [DataNormalisasiController::class, 'index'])->name('normalisasi.index');
    Route::get('/alternatif', [InfluencerController::class, 'index'])->name('alternatif.index');
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/nilai-alternatif', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/perhitungan', [FuzzyTopsisController::class, 'index'])->name('perhitungan.index');
    Route::post('/perhitungan/proses', [FuzzyTopsisController::class, 'proses'])->name('perhitungan.proses');

    /**
     * Route CRUD hanya untuk ADMIN
     */
    Route::middleware('admin')->group(function () {
        // CRUD Influencer
        Route::post('/alternatif', [InfluencerController::class, 'store'])->name('influencer.store');
        Route::put('/alternatif/{id}', [InfluencerController::class, 'update'])->name('influencer.update');
        Route::delete('/alternatif/{id}', [InfluencerController::class, 'destroy'])->name('influencer.destroy');

        // CRUD Kriteria
        Route::post('/kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
        Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
        Route::delete('/kriteria/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');
    });

    /**
     * Profile
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
