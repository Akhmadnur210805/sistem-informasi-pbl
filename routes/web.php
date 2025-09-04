<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DataMahasiswaController;
use App\Http\Controllers\DataDosenController;
use App\Http\Controllers\DataPengelolaController;
use Illuminate\Support\Facades\Route;


// Rute utama akan diarahkan ke halaman login
Route::get('/', function () {
    return redirect('/login');
});

// Rute untuk pengguna yang belum login (Tamu)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rute Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Grup untuk semua rute yang memerlukan login ---
Route::middleware(['auth'])->group(function () {
    
    // Rute Dashboard Mahasiswa
    Route::get('/dashboard_mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');

    // Rute Dashboard Admin
    Route::get('/dashboard_admin', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Data Mahasiswa
    Route::get('/admin/mahasiswa', [DataMahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
   
    Route::get('/admin/mahasiswa/create', [DataMahasiswaController::class, 'create'])->name('admin.mahasiswa.create'); // <-- Tambah ini
    Route::post('/admin/mahasiswa', [DataMahasiswaController::class, 'store'])->name('admin.mahasiswa.store'); // <-- Tambah ini
    Route::get('/admin/mahasiswa/{mahasiswa}/edit', [DataMahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit'); // <-- Tambah ini
    Route::put('/admin/mahasiswa/{mahasiswa}', [DataMahasiswaController::class, 'update'])->name('admin.mahasiswa.update'); // <-- Tambah ini
    // Rute Hapus Mahasiswa (Tambahkan ini)
    Route::delete('/admin/mahasiswa/{mahasiswa}', [DataMahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');

    // Rute Data Dosen (Tambahkan ini)
    Route::get('/admin/dosen', [DataDosenController::class, 'index'])->name('admin.dosen.index');
    Route::get('/admin/dosen/create', [DataDosenController::class, 'create'])->name('admin.dosen.create'); // <-- Tambah ini
    Route::post('/admin/dosen', [DataDosenController::class, 'store'])->name('admin.dosen.store'); // <-- Tambah ini
    Route::get('/admin/dosen/{dosen}/edit', [DataDosenController::class, 'edit'])->name('admin.dosen.edit'); // <-- Tambah ini
    Route::put('/admin/dosen/{dosen}', [DataDosenController::class, 'update'])->name('admin.dosen.update'); // <-- Tambah ini
    Route::delete('/admin/dosen/{dosen}', [DataDosenController::class, 'destroy'])->name('admin.dosen.destroy');
    
    // Rute Data Pengelola (Tambahkan ini)
    Route::get('/admin/pengelola', [DataPengelolaController::class, 'index'])->name('admin.pengelola.index');
    // Nanti, Anda bisa menambahkan rute lain yang butuh login di dalam grup ini.
    // Contoh: Route::get('/profil', [ProfileController::class, 'show']);
    
});