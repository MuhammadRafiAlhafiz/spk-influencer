<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\FuzzyTopsisController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\DataNormalisasiController;
use App\Http\Controllers\RespondenController;
use App\Http\Controllers\SinkronisasiController;
use App\Http\Controllers\TerbobotController;
use App\Http\Controllers\DashboardController;

// Redirect ke login saat akses root
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    // ROUTE YANG BISA DIAKSES SEMUA USER LOGIN
    Route::post('/responden/sinkronisasi', [SinkronisasiController::class, 'sinkronisasi'])->name('responden.sinkronisasi');
    Route::get('/perhitungan', [FuzzyTopsisController::class, 'index'])->name('perhitungan.index');

    Route::get('/terbobot', [TerbobotController::class, 'index'])->name('terbobot.index');
    Route::get('/data-normalisasi', [DataNormalisasiController::class, 'index'])->name('normalisasi.index');
    Route::get('/responden', [RespondenController::class, 'index'])->name('responden.index');
    Route::get('/alternatif', [InfluencerController::class, 'index'])->name('alternatif.index');
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/nilai-alternatif', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/perhitungan', [FuzzyTopsisController::class, 'index'])->name('perhitungan.index');
    Route::post('/perhitungan/proses', [FuzzyTopsisController::class, 'proses'])->name('perhitungan.proses');

    // CRUD hanya untuk ADMIN
        Route::middleware('admin')->group(function () {
        Route::post('/responden', [RespondenController::class, 'store'])->name('responden.store');
        Route::put('/responden/{id}', [RespondenController::class, 'update'])->name('responden.update');
        Route::delete('/responden/{responden}', [RespondenController::class, 'destroy'])->name('responden.destroy');

        Route::post('/kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
        Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
        Route::delete('/kriteria/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');
    });

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
