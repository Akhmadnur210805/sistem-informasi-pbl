<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan data dinamis.
     */
    public function index(): View
    {
        // Hitung jumlah mahasiswa
        $jumlahMahasiswa = User::where('role', 'mahasiswa')->count();

        // Hitung jumlah dosen
        $jumlahDosen = User::where('role', 'dosen')->count();

        // Hitung jumlah pengelola (BARIS BARU)
        $jumlahPengelola = User::where('role', 'pengelola')->count();

        // Ambil mahasiswa untuk ranking
        $rankedMahasiswas = User::where('role', 'mahasiswa')->latest()->take(4)->get();

        // Kirim semua data yang dibutuhkan ke view
        return view('admin.dashboard', [
            'jumlahMahasiswa' => $jumlahMahasiswa,
            'jumlahDosen' => $jumlahDosen,
            'jumlahPengelola' => $jumlahPengelola, // <-- Kirim data baru
            'rankedMahasiswas' => $rankedMahasiswas,
        ]);
    }
}