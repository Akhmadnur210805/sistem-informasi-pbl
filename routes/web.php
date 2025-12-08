<?php

use Illuminate\Support\Facades\Route;

// Import Semua Controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenDashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PengelolaDashboardController;

// Controller Data Master (Admin)
use App\Http\Controllers\DataDosenController;
use App\Http\Controllers\DataKelompokController;
use App\Http\Controllers\DataMahasiswaController;
use App\Http\Controllers\DataMataKuliahController;
use App\Http\Controllers\DataPengelolaController;

// Controller Fitur Dosen
use App\Http\Controllers\DosenPenilaianController;
use App\Http\Controllers\DosenPenilaianKelompokController;
use App\Http\Controllers\DosenRekapController;

// Controller Fitur Mahasiswa
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\PeerReviewController;
use App\Http\Controllers\MahasiswaNilaiController;

// Controller Fitur Umum/Pengelola
use App\Http\Controllers\RankingController;
use App\Http\Controllers\RekapNilaiController; // <-- Controller Rekap & PDF
use App\Http\Controllers\PengelolaViewController;


// ====================================================
// RUTE PUBLIK (Tamu)
// ====================================================
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Login Google
Route::get('google/login', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/google/callback', [AuthController::class, 'handleGoogleCallback']);


// ====================================================
// RUTE TERAUTENTIKASI (Harus Login)
// ====================================================
Route::middleware(['auth'])->group(function () {

    // --- DASHBOARD ---
    Route::get('/dashboard_admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard_dosen', [DosenDashboardController::class, 'index'])->name('dosen.dashboard');
    Route::get('/dashboard_mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
    Route::get('/dashboard_pengelola', [PengelolaDashboardController::class, 'index'])->name('pengelola.dashboard');


    // --- GRUP MAHASISWA ---
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function() {
        // Logbook Mingguan
        Route::get('/logbook', [LogbookController::class, 'index'])->name('logbook.index');
        Route::post('/logbook', [LogbookController::class, 'store'])->name('logbook.store');
        
        // Penilaian Teman Sejawat
        Route::get('/penilaian-sejawat', [PeerReviewController::class, 'index'])->name('penilaian_sejawat.index');
        Route::post('/penilaian-sejawat', [PeerReviewController::class, 'store'])->name('penilaian_sejawat.store');
        
        // Hasil Penilaian Studi (Nilai dari Dosen)
        Route::get('/hasil-penilaian', [MahasiswaNilaiController::class, 'index'])->name('nilai.index');

        // Ranking (SAW)
        Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    });


    // --- GRUP DOSEN ---
    Route::prefix('dosen')->name('dosen.')->group(function() {
        // Kelompok
        Route::get('/kelompok', [DataKelompokController::class, 'index'])->name('kelompok.index');
        
        // Penilaian Individu (Matkul & Presentasi)
        Route::get('/penilaian', [DosenPenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('/penilaian/{matakuliah}/{kelas}', [DosenPenilaianController::class, 'showPenilaianForm'])->name('penilaian.form');
        Route::post('/penilaian/{matakuliah}/{kelas}', [DosenPenilaianController::class, 'storePenilaian'])->name('penilaian.store');
        
        // Penilaian Kelompok (Proyek, Kerjasama, Presentasi Kelompok)
        Route::get('/penilaian-kelompok', [DosenPenilaianKelompokController::class, 'index'])->name('penilaian_kelompok.index');
        Route::post('/penilaian-kelompok', [DosenPenilaianKelompokController::class, 'store'])->name('penilaian_kelompok.store');

        // Rekapitulasi (Monitoring Mahasiswa)
        Route::get('/rekap-logbook', [DosenRekapController::class, 'rekapLogbook'])->name('rekap.logbook');
        Route::get('/rekap-penilaian-sejawat', [DosenRekapController::class, 'rekapPenilaianSejawat'])->name('rekap.penilaian_sejawat');
        Route::get('/rekap-penilaian-sejawat/{id}', [DosenRekapController::class, 'rekapPenilaianSejawatDetail'])->name('rekap.penilaian_sejawat_detail');

        // Ranking
        Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    });


    // --- GRUP PENGELOLA ---
    Route::prefix('pengelola')->name('pengelola.')->group(function() {
        Route::get('/data-mahasiswa', [PengelolaViewController::class, 'showMahasiswa'])->name('mahasiswa.index');
        Route::get('/data-dosen', [PengelolaViewController::class, 'showDosen'])->name('dosen.index');
        
        // Rekap Nilai Akhir (SAW) & Export PDF
        Route::get('/rekap-nilai', [RekapNilaiController::class, 'index'])->name('rekap_nilai.index');
        Route::get('/rekap-nilai/download', [RekapNilaiController::class, 'downloadPDF'])->name('rekap_nilai.download'); // <-- Rute Baru PDF

        Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    });


    // --- GRUP ADMIN (CRUD & Import) ---
    Route::prefix('admin')->name('admin.')->group(function () {
        // CRUD & Import Mahasiswa
        Route::resource('mahasiswa', DataMahasiswaController::class)->except(['show']);
        Route::post('mahasiswa/import', [DataMahasiswaController::class, 'importExcel'])->name('mahasiswa.import');
        
        // CRUD & Import Dosen
        Route::resource('dosen', DataDosenController::class)->except(['show']);
        Route::post('dosen/import', [DataDosenController::class, 'importExcel'])->name('dosen.import');
        // TAMBAHKAN INI: Route khusus untuk ubah status (Hanya bisa diakses Admin)
         Route::post('dosen/{id}/toggle-status', [DataDosenController::class, 'toggleStatus'])->name('dosen.toggleStatus');

        // CRUD & Import Pengelola
        Route::resource('pengelola', DataPengelolaController::class)->except(['show']);
        Route::post('pengelola/import', [DataPengelolaController::class, 'importExcel'])->name('pengelola.import');
        
        // CRUD & Import Mata Kuliah
        Route::resource('matakuliah', DataMataKuliahController::class)->except(['show']);
        Route::post('matakuliah/import', [DataMataKuliahController::class, 'importExcel'])->name('matakuliah.import');
        
        // Lainnya
        Route::get('/kelompok', [DataKelompokController::class, 'index'])->name('kelompok.index');
        Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    });
});