<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenDashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PengelolaDashboardController;
use App\Http\Controllers\DataDosenController;
use App\Http\Controllers\DataKelompokController;
use App\Http\Controllers\DataMahasiswaController;
use App\Http\Controllers\DataMataKuliahController;
use App\Http\Controllers\DataPengelolaController;
use App\Http\Controllers\DosenPenilaianController;
use App\Http\Controllers\PengelolaViewController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\RekapNilaiController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\PeerReviewController;
use App\Http\Controllers\DosenRekapController;
use App\Http\Controllers\Auth\GoogleLoginController; // <-- INI DITAMBAHKAN

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

// --- INI RUTE GOOGLE YANG DIUBAH ---
// Rute untuk mengarahkan ke Google
Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.login');
// Rute untuk menangani callback dari Google
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);
// -------------------------------------

// --- Grup untuk semua rute yang memerlukan login ---
Route::middleware(['auth'])->group(function () {

    // == HALAMAN UTAMA SETELAH LOGIN (DASHBOARD) ==
    Route::get('/dashboard_admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard_dosen', [DosenDashboardController::class, 'index'])->name('dosen.dashboard');
    Route::get('/dashboard_mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
    Route::get('/dashboard_pengelola', [PengelolaDashboardController::class, 'index'])->name('pengelola.dashboard');

    // == RUTE KHUSUS MAHASISWA ==
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function() {
        Route::get('/logbook', [LogbookController::class, 'index'])->name('logbook.index');
        Route::post('/logbook', [LogbookController::class, 'store'])->name('logbook.store');
        Route::get('/penilaian-sejawat', [PeerReviewController::class, 'index'])->name('penilaian_sejawat.index');
        Route::post('/penilaian-sejawat', [PeerReviewController::class, 'store'])->name('penilaian_sejawat.store');
        Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    });

    // == RUTE KHUSUS DOSEN ==
    Route::prefix('dosen')->name('dosen.')->group(function() {
        Route::get('/kelompok', [DataKelompokController::class, 'index'])->name('kelompok.index');
        Route::get('/penilaian', [DosenPenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('/penilaian/{matakuliah}/{kelas}', [DosenPenilaianController::class, 'showPenilaianForm'])->name('penilaian.form');
        Route::post('/penilaian/{matakuliah}/{kelas}', [DosenPenilaianController::class, 'storePenilaian'])->name('penilaian.store');
        Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');

        // Route baru untuk Rekap
        Route::get('/rekap-logbook', [DosenRekapController::class, 'rekapLogbook'])->name('rekap.logbook');
        Route::get('/rekap-penilaian-sejawat', [DosenRekapController::class, 'rekapPenilaianSejawat'])->name('rekap.penilaian_sejawat');
    });

    // == RUTE KHUSUS PENGELOLA ==
    Route::prefix('pengelola')->name('pengelola.')->group(function() {
        Route::get('/data-mahasiswa', [PengelolaViewController::class, 'showMahasiswa'])->name('mahasiswa.index');
        Route::get('/data-dosen', [PengelolaViewController::class, 'showDosen'])->name('dosen.index');
        Route::get('/rekap-nilai', [RekapNilaiController::class, 'index'])->name('rekap_nilai.index');
        Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    });

    // == RUTE KHUSUS ADMIN (CRUD & MANAJEMEN) ==
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('mahasiswa', DataMahasiswaController::class)->except(['show']);
        Route::post('mahasiswa/import', [DataMahasiswaController::class, 'importExcel'])->name('mahasiswa.import');
        Route::resource('dosen', DataDosenController::class)->except(['show']);
        Route::post('dosen/import', [DataDosenController::class, 'importExcel'])->name('dosen.import');
        Route::resource('pengelola', DataPengelolaController::class)->except(['show']);
        Route::post('pengelola/import', [DataPengelolaController::class, 'importExcel'])->name('pengelola.import');
        Route::resource('matakuliah', DataMataKuliahController::class)->except(['show']);
        Route::post('matakuliah/import', [DataMataKuliahController::class, 'importExcel'])->name('matakuliah.import');
        Route::get('/kelompok', [DataKelompokController::class, 'index'])->name('kelompok.index');
        Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    });
});
