<?php

namespace App\Http\Controllers;

use App\Models\KategoriBantuan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Menampilkan Halaman Utama (Landing Page) Publik
     * Bisa diakses oleh siapa saja tanpa perlu login.
     */
    public function index(): View
    {
        // Mengambil semua program bantuan yang statusnya aktif (is_active = true/1)
        // Diurutkan dari yang paling baru ditambahkan (latest)
        $daftarBantuan = KategoriBantuan::where('is_active', true)
                                        ->latest() 
                                        ->get();
        
        // Mengirim data ke tampilan resources/views/landing.blade.php
        return view('landing', compact('daftarBantuan'));
    }
}