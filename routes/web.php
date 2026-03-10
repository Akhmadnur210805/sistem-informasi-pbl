<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MustahikController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\KategoriBantuanController;
use App\Http\Controllers\LandingController;
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
    
    // Auth Google
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
    Route::prefix('mustahik')->name('mustahik.')->group(function () {
        Route::get('/dashboard', [MustahikController::class, 'dashboard'])->name('dashboard');
        
        // Form Dinamis Pengajuan
        Route::get('/ajukan-bantuan/{id}', [MustahikController::class, 'createPengajuan'])->name('pengajuan.create');
        Route::post('/ajukan-bantuan/simpan', [MustahikController::class, 'storePengajuan'])->name('pengajuan.store');
        
        // Riwayat
        Route::get('/riwayat-pengajuan', [MustahikController::class, 'riwayat'])->name('riwayat');
        Route::get('/riwayat-pengajuan/detail/{id}', [MustahikController::class, 'showDetail'])->name('pengajuan.detail');

        // Profil
        Route::get('/profil', [MustahikController::class, 'profil'])->name('profil');
    });

    // ------------------------------------------
    // B. AREA PETUGAS (Admin Verifikator)
    // ------------------------------------------
    Route::prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
        
        // Kelola Mustahik (Admin)
        Route::get('/kelola-mustahik', [PetugasController::class, 'indexMustahik'])->name('mustahik.index');
        Route::get('/kelola-mustahik/detail/{id}', [PetugasController::class, 'showMustahik'])->name('mustahik.show');
        Route::delete('/kelola-mustahik/hapus/{id}', [PetugasController::class, 'destroyMustahik'])->name('mustahik.destroy');
        
        // Verifikasi & Log
        Route::get('/verifikasi-pengajuan', [PetugasController::class, 'indexVerifikasi'])->name('verifikasi.index');
        Route::get('/verifikasi-pengajuan/detail/{id}', [PetugasController::class, 'showVerifikasi'])->name('verifikasi.show');
        Route::post('/verifikasi-pengajuan/proses/{id}', [PetugasController::class, 'prosesVerifikasi'])->name('verifikasi.proses');
        Route::get('/log-pengajuan', [PetugasController::class, 'logPengajuan'])->name('log.index');

        // Cetak PDF
        Route::get('/verifikasi-pengajuan/download/{id}', [PetugasController::class, 'downloadProfil'])->name('pengajuan.download');

        // Data Master: Kategori Bantuan
        Route::get('/kategori-bantuan', [KategoriBantuanController::class, 'index'])->name('kategori.index');
        Route::get('/kategori-bantuan/tambah', [KategoriBantuanController::class, 'create'])->name('kategori.create');
        Route::post('/kategori-bantuan/simpan', [KategoriBantuanController::class, 'store'])->name('kategori.store');
        Route::get('/kategori-bantuan/edit/{id}', [KategoriBantuanController::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori-bantuan/update/{id}', [KategoriBantuanController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori-bantuan/hapus/{id}', [KategoriBantuanController::class, 'destroy'])->name('kategori.destroy');
    });

    // ------------------------------------------
    // C. AREA PIMPINAN (Monitoring & Laporan)
    // ------------------------------------------
    Route::prefix('pimpinan')->name('pimpinan.')->group(function () {
        Route::get('/dashboard', [PimpinanController::class, 'dashboard'])->name('dashboard');
        
        // Rute Fitur Laporan Pimpinan
        Route::get('/laporan', [PimpinanController::class, 'indexLaporan'])->name('laporan.index');
        Route::post('/laporan/cetak', [PimpinanController::class, 'cetakLaporan'])->name('laporan.cetak');

        // Rute Fitur Pantau Data Mustahik
        Route::get('/data-mustahik', [PimpinanController::class, 'indexMustahik'])->name('mustahik.index');

        // Rute Fitur Log Aktivitas Petugas
        Route::get('/log-aktivitas', [PimpinanController::class, 'logAktivitas'])->name('log.index');

        // Rute Fitur Pengaturan Akun (Tampilan & Simpan)
        Route::get('/pengaturan', [PimpinanController::class, 'pengaturanAkun'])->name('pengaturan.index');
        Route::post('/pengaturan/update', [PimpinanController::class, 'updatePengaturan'])->name('pengaturan.update');
    });

});