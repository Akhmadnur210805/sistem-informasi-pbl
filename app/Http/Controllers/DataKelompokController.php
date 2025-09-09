<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse; // <-- TAMBAHKAN INI

class DataKelompokController extends Controller
{
    /**
     * Menampilkan halaman rekapitulasi data kelompok.
     */
    public function index(): View|RedirectResponse // <-- UBAH DI SINI
    {
        $mahasiswas = User::where('role', 'mahasiswa')
                            ->whereNotNull('kelompok')
                            ->orderBy('kelas', 'asc')
                            ->orderBy('kelompok', 'asc')
                            ->get();

        $kelompoks = $mahasiswas->groupBy(['kelas', 'kelompok']);
        
        $data = ['kelompoks' => $kelompoks];

        // Cek peran user dan tampilkan view yang sesuai
        if (Auth::user()->role == 'admin') {
            return view('admin.kelompok.index', $data);
        }

        if (Auth::user()->role == 'dosen') {
            return view('dosen.kelompok.index', $data);
        }

        // Fallback jika ada role lain yang mengakses
        return redirect()->back();
    }
}