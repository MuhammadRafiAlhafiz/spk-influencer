<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\FuzzyTopsisController;
use App\Http\Controllers\AuthenticatedSessionController;


// Redirect ke login saat akses root
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ✅ Bisa diakses semua user login
Route::middleware(['auth'])->group(function () {
    Route::get('/alternatif', [InfluencerController::class, 'index'])->name('alternatif.index');
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/nilai-alternatif', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/perhitungan', [FuzzyTopsisController::class, 'index'])->name('perhitungan.index');
    Route::post('/perhitungan/proses', [FuzzyTopsisController::class, 'proses'])->name('perhitungan.proses');

    // ✅ Hanya admin yang bisa akses CRUD
    Route::middleware(['admin'])->group(function () {
        Route::post('/influencer', [InfluencerController::class, 'store'])->name('influencer.store');
        Route::put('/influencer/{id}', [InfluencerController::class, 'update'])->name('influencer.update');
        Route::delete('/influencer/{id}', [InfluencerController::class, 'destroy'])->name('influencer.destroy');
    });

    // ✅ Edit profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

