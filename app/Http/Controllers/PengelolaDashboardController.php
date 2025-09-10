<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\DB;

class PengelolaDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard pengelola.
     */
    public function index(): View
    {
        // Data untuk Info Boxes
        $jumlahMahasiswa = User::where('role', 'mahasiswa')->count();
        $jumlahDosen = User::where('role', 'dosen')->count();
        $jumlahKelompok = User::where('role', 'mahasiswa')
                            ->whereNotNull('kelompok')
                            ->select('kelompok', 'kelas')
                            ->groupBy('kelompok', 'kelas')
                            ->get()
                            ->count();

        // Data untuk Tabel Ranking (Top 4)
        $rankedMahasiswas = User::where('role', 'mahasiswa')
            ->leftJoin('penilaians', 'users.id', '=', 'penilaians.user_id')
            ->select('users.id', 'users.name', 'users.kelas', DB::raw('AVG(penilaians.nilai) as rata_rata_nilai'))
            ->groupBy('users.id', 'users.name', 'users.kelas')
            ->orderByDesc('rata_rata_nilai')
            ->take(4)
            ->get();
        
        $rankedKelompoks = User::where('role', 'mahasiswa')
            ->whereNotNull('kelompok')
            ->leftJoin('penilaians', 'users.id', '=', 'penilaians.user_id')
            ->select('users.kelompok', 'users.kelas', DB::raw('AVG(penilaians.nilai) as rata_rata_nilai'))
            ->groupBy('users.kelompok', 'users.kelas')
            ->orderByDesc('rata_rata_nilai')
            ->take(4)
            ->get();

        return view('pengelola.dashboard', [
            'jumlahMahasiswa' => $jumlahMahasiswa,
            'jumlahDosen' => $jumlahDosen,
            'jumlahKelompok' => $jumlahKelompok,
            'rankedMahasiswas' => $rankedMahasiswas, // Kirim data ranking mahasiswa
            'rankedKelompoks' => $rankedKelompoks,   // Kirim data ranking kelompok
        ]);
    }
}