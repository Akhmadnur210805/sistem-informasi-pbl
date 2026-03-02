<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MustahikController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\KategoriBantuanController;

/*
|--------------------------------------------------------------------------
| Web Routes - SIMPATIK BAZNAS (VERSI MASTER FINAL)
|--------------------------------------------------------------------------
*/

// --- GRUP TAMU (GUEST) ---
Route::middleware(['guest'])->group(function () {
    
    // Auth Manual
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login/manual', [AuthController::class, 'login'])->name('login.manual');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    
    // Auth Google
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

// --- GRUP TERAUTENTIKASI (WAJIB LOGIN) ---
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- AREA KHUSUS MUSTAHIK ---
    Route::prefix('mustahik')->group(function () {
        Route::get('/dashboard', [MustahikController::class, 'dashboard'])->name('mustahik.dashboard');
        
        // Operasional Pengajuan
        Route::get('/ajukan-bantuan/{id}', [MustahikController::class, 'createPengajuan'])->name('mustahik.pengajuan.create');
        Route::post('/ajukan-bantuan/simpan', [MustahikController::class, 'storePengajuan'])->name('mustahik.pengajuan.store');
        Route::get('/riwayat-pengajuan', [MustahikController::class, 'riwayat'])->name('mustahik.riwayat');
        Route::get('/riwayat-pengajuan/detail/{id}', [MustahikController::class, 'showDetail'])->name('mustahik.pengajuan.detail');

        // Fitur Informasi
        Route::get('/tentang-baznas', [MustahikController::class, 'about'])->name('mustahik.about');
    });

    // --- AREA KHUSUS PETUGAS ---
    Route::prefix('petugas')->group(function () {
        // Dashboard
        Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
        
        // --- FITUR: KELOLA MUSTAHIK ---
        // Pastikan link di sidebar mengarah ke 'petugas.mustahik.index'
        Route::get('/kelola-mustahik', [PetugasController::class, 'indexMustahik'])->name('petugas.mustahik.index');
        Route::get('/kelola-mustahik/detail/{id}', [PetugasController::class, 'showMustahik'])->name('petugas.mustahik.show');
        Route::delete('/kelola-mustahik/hapus/{id}', [PetugasController::class, 'destroyMustahik'])->name('petugas.mustahik.destroy');
        
        // --- FITUR: VERIFIKASI & LOG ---
        Route::get('/verifikasi-pengajuan', [PetugasController::class, 'indexVerifikasi'])->name('petugas.verifikasi.index');
        Route::get('/verifikasi-pengajuan/detail/{id}', [PetugasController::class, 'showVerifikasi'])->name('petugas.verifikasi.show');
        Route::post('/verifikasi-pengajuan/proses/{id}', [PetugasController::class, 'prosesVerifikasi'])->name('petugas.verifikasi.proses');
        Route::get('/log-pengajuan', [PetugasController::class, 'logPengajuan'])->name('petugas.log.index');

        // Fitur Inovasi (Cetak PDF)
        Route::get('/verifikasi-pengajuan/download/{id}', [PetugasController::class, 'downloadProfil'])->name('petugas.pengajuan.download');

        // --- DATA MASTER: KATEGORI BANTUAN ---
        Route::get('/kategori-bantuan', [KategoriBantuanController::class, 'index'])->name('petugas.kategori.index');
        Route::get('/kategori-bantuan/tambah', [KategoriBantuanController::class, 'create'])->name('petugas.kategori.create');
        Route::post('/kategori-bantuan/simpan', [KategoriBantuanController::class, 'store'])->name('petugas.kategori.store');
        Route::get('/kategori-bantuan/edit/{id}', [KategoriBantuanController::class, 'edit'])->name('petugas.kategori.edit');
        Route::put('/kategori-bantuan/update/{id}', [KategoriBantuanController::class, 'update'])->name('petugas.kategori.update');
        Route::delete('/kategori-bantuan/hapus/{id}', [KategoriBantuanController::class, 'destroy'])->name('petugas.kategori.destroy');
    });

    // --- AREA KHUSUS PIMPINAN ---
    Route::prefix('pimpinan')->group(function () {
        Route::get('/dashboard', [PimpinanController::class, 'dashboard'])->name('pimpinan.dashboard');
    });
});