<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DataMahasiswaController;
use App\Http\Controllers\DataDosenController;
use App\Http\Controllers\DataPengelolaController;
use App\Http\Controllers\DataKelompokController;
use App\Http\Controllers\DataMataKuliahController;
use App\Http\Controllers\DosenDashboardController;
use App\Http\Controllers\DosenPenilaianController;
use App\Http\Controllers\PengelolaDashboardController;
use App\Http\Controllers\RekapNilaiController;
use App\Http\Controllers\PengelolaViewController;
use App\Http\Controllers\RankingController;


// Rute utama
Route::get('/', function () {
    return redirect('/login');
});

// Rute untuk tamu (belum login)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- Grup untuk semua rute yang memerlukan login ---
Route::middleware(['auth'])->group(function () {
    
    // Rute Dashboard
    Route::get('/dashboard_admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard_dosen', [DosenDashboardController::class, 'index'])->name('dosen.dashboard');
    Route::get('/dashboard_mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');


    // Rute Dashboard Pengelola
    Route::get('/dashboard_pengelola', [PengelolaDashboardController::class, 'index'])->name('pengelola.dashboard');

    // Rute Rekap Nilai Pengelola
    Route::get('/pengelola/rekap-nilai', [RekapNilaiController::class, 'index'])->name('pengelola.rekap_nilai.index');

    // Rute Ranking Pengelola
    Route::get('/pengelola/ranking', [RankingController::class, 'index'])->name('pengelola.ranking.index');

    // Rute Read-Only untuk Pengelola
    Route::get('/pengelola/data-mahasiswa', [PengelolaViewController::class, 'showMahasiswa'])->name('pengelola.mahasiswa.index');
    Route::get('/pengelola/data-dosen', [PengelolaViewController::class, 'showDosen'])->name('pengelola.dosen.index');



    // --- Grup untuk rute dosen ---
    // Rute Ranking Dosen (menggunakan controller yang sama dengan admin)
    Route::get('/dosen/ranking', [RankingController::class, 'index'])->name('dosen.ranking.index');

    // Rute Kelompok PBL Dosen (menggunakan controller yang sama dengan admin)
    Route::get('/dosen/kelompok', [DataKelompokController::class, 'index'])->name('dosen.kelompok.index');

    // Rute Penilaian Dosen
    Route::get('/dosen/penilaian', [DosenPenilaianController::class, 'index'])->name('dosen.penilaian.index');
    Route::get('/dosen/penilaian/{matakuliah}', [DosenPenilaianController::class, 'showPenilaianForm'])->name('dosen.penilaian.form');
    Route::post('/dosen/penilaian/{matakuliah}', [DosenPenilaianController::class, 'storePenilaian'])->name('dosen.penilaian.store');

    
    // --- Grup untuk rute admin ---
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Rute Data Mahasiswa
        Route::get('/mahasiswa', [DataMahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/mahasiswa/create', [DataMahasiswaController::class, 'create'])->name('mahasiswa.create');
        Route::post('/mahasiswa', [DataMahasiswaController::class, 'store'])->name('mahasiswa.store');
        Route::get('/mahasiswa/{mahasiswa}/edit', [DataMahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('/mahasiswa/{mahasiswa}', [DataMahasiswaController::class, 'update'])->name('mahasiswa.update');
        Route::delete('/mahasiswa/{mahasiswa}', [DataMahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

        // Rute Data Dosen
        Route::get('/dosen', [DataDosenController::class, 'index'])->name('dosen.index');
        Route::get('/dosen/create', [DataDosenController::class, 'create'])->name('dosen.create');
        Route::post('/dosen', [DataDosenController::class, 'store'])->name('dosen.store');
        Route::get('/dosen/{dosen}/edit', [DataDosenController::class, 'edit'])->name('dosen.edit');
        Route::put('/dosen/{dosen}', [DataDosenController::class, 'update'])->name('dosen.update');
        Route::delete('/dosen/{dosen}', [DataDosenController::class, 'destroy'])->name('dosen.destroy');

        // Rute Data Pengelola
        Route::get('/pengelola', [DataPengelolaController::class, 'index'])->name('pengelola.index');
        Route::get('/pengelola/create', [DataPengelolaController::class, 'create'])->name('pengelola.create');
        Route::post('/pengelola', [DataPengelolaController::class, 'store'])->name('pengelola.store');
        Route::get('/pengelola/{pengelola}/edit', [DataPengelolaController::class, 'edit'])->name('pengelola.edit');
        Route::put('/pengelola/{pengelola}', [DataPengelolaController::class, 'update'])->name('pengelola.update');
        Route::delete('/pengelola/{pengelola}', [DataPengelolaController::class, 'destroy'])->name('pengelola.destroy');

        // Rute Data Kelompok
        Route::get('/kelompok', [DataKelompokController::class, 'index'])->name('kelompok.index');
        
        // Rute Ranking
        Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
        
        // Rute Data Mata Kuliah
        Route::resource('matakuliah', DataMataKuliahController::class);
    });
});