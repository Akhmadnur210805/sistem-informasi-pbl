<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MustahikController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\KategoriBantuanController;
use App\Http\Controllers\LandingController;

// TAMBAHAN WAJIB: Panggil GoogleLoginController yang ada di folder Auth
use App\Http\Controllers\Auth\GoogleLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes - SIMPATIK BAZNAS (VERSI MASTER FINAL)
|--------------------------------------------------------------------------
*/

// ==========================================
// 0. HALAMAN UTAMA PUBLIK (LANDING PAGE)
// ==========================================
Route::get('/', [LandingController::class, 'index'])->name('landing');


// ==========================================
// 1. GRUP TAMU (Belum Login)
// ==========================================
Route::middleware(['guest'])->group(function () {
    
    // Auth Manual
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login/manual', [AuthController::class, 'login'])->name('login.manual');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    
    // ==========================================
    // PERBAIKAN: Arahkan Auth Google ke GoogleLoginController
    // ==========================================
    Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);
});


// ==========================================
// 2. GRUP PENGGUNA TERAUTENTIKASI (Sudah Login)
// ==========================================
Route::middleware(['auth'])->group(function () {

    // Global Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ------------------------------------------
    // A. AREA MUSTAHIK (Penerima Manfaat)
    // ------------------------------------------
    Route::prefix('mustahik')->group(function () {
        Route::get('/dashboard', [MustahikController::class, 'dashboard'])->name('mustahik.dashboard');
        
        // Form Dinamis Pengajuan
        Route::get('/ajukan-bantuan/{id}', [MustahikController::class, 'createPengajuan'])->name('mustahik.pengajuan.create');
        Route::post('/ajukan-bantuan/simpan', [MustahikController::class, 'storePengajuan'])->name('mustahik.pengajuan.store');
        
        // Riwayat
        Route::get('/riwayat-pengajuan', [MustahikController::class, 'riwayat'])->name('mustahik.riwayat');
        Route::get('/riwayat-pengajuan/detail/{id}', [MustahikController::class, 'showDetail'])->name('mustahik.pengajuan.detail');

        // ==========================================
        // RUTE PROFIL PENGGUNA
        // ==========================================
        Route::get('/profil', [MustahikController::class, 'profil'])->name('mustahik.profil');
    });

    // ------------------------------------------
    // B. AREA PETUGAS (Admin Verifikator)
    // ------------------------------------------
    Route::prefix('petugas')->group(function () {
        Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
        
        // Kelola Mustahik
        Route::get('/kelola-mustahik', [PetugasController::class, 'indexMustahik'])->name('petugas.mustahik.index');
        Route::get('/kelola-mustahik/detail/{id}', [PetugasController::class, 'showMustahik'])->name('petugas.mustahik.show');
        Route::delete('/kelola-mustahik/hapus/{id}', [PetugasController::class, 'destroyMustahik'])->name('petugas.mustahik.destroy');
        
        // Verifikasi & Log
        Route::get('/verifikasi-pengajuan', [PetugasController::class, 'indexVerifikasi'])->name('petugas.verifikasi.index');
        Route::get('/verifikasi-pengajuan/detail/{id}', [PetugasController::class, 'showVerifikasi'])->name('petugas.verifikasi.show');
        Route::post('/verifikasi-pengajuan/proses/{id}', [PetugasController::class, 'prosesVerifikasi'])->name('petugas.verifikasi.proses');
        Route::get('/log-pengajuan', [PetugasController::class, 'logPengajuan'])->name('petugas.log.index');

        // Cetak PDF
        Route::get('/verifikasi-pengajuan/download/{id}', [PetugasController::class, 'downloadProfil'])->name('petugas.pengajuan.download');

        // Data Master: Kategori Bantuan
        Route::get('/kategori-bantuan', [KategoriBantuanController::class, 'index'])->name('petugas.kategori.index');
        Route::get('/kategori-bantuan/tambah', [KategoriBantuanController::class, 'create'])->name('petugas.kategori.create');
        Route::post('/kategori-bantuan/simpan', [KategoriBantuanController::class, 'store'])->name('petugas.kategori.store');
        Route::get('/kategori-bantuan/edit/{id}', [KategoriBantuanController::class, 'edit'])->name('petugas.kategori.edit');
        Route::put('/kategori-bantuan/update/{id}', [KategoriBantuanController::class, 'update'])->name('petugas.kategori.update');
        Route::delete('/kategori-bantuan/hapus/{id}', [KategoriBantuanController::class, 'destroy'])->name('petugas.kategori.destroy');
    });

    // ------------------------------------------
    // C. AREA PIMPINAN (Monitoring & Laporan)
    // ------------------------------------------
    Route::prefix('pimpinan')->group(function () {
        Route::get('/dashboard', [PimpinanController::class, 'dashboard'])->name('pimpinan.dashboard');
        
        // Tambahan Rute Baru untuk Fitur Laporan Pimpinan
        Route::get('/laporan', [PimpinanController::class, 'indexLaporan'])->name('pimpinan.laporan.index');
        Route::post('/laporan/cetak', [PimpinanController::class, 'cetakLaporan'])->name('pimpinan.laporan.cetak');
    });

});