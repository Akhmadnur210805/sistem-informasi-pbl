<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan halaman dashboard mahasiswa.
     */
    public function index(): View
    {
        // 'mhs.dashboard' mengacu pada folder 'mhs' dan file 'dashboard.blade.php'
        return view('mhs.dashboard');
    }
}