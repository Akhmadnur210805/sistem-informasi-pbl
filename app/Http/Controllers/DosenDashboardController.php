<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\DB;

class DosenDashboardController extends Controller
{
    public function index(): View
    {
        // Data untuk Info Boxes
        $jumlahMahasiswa = User::where('role', 'mahasiswa')->count();
        $jumlahMataKuliah = MataKuliah::count();
        $jumlahKelompok = User::where('role', 'mahasiswa')
                            ->whereNotNull('kelompok')
                            ->select('kelompok', 'kelas')
                            ->groupBy('kelompok', 'kelas')
                            ->get()
                            ->count();

        // Data untuk Tabel Ranking
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

        return view('dosen.dashboard', [
            'jumlahMahasiswa' => $jumlahMahasiswa,
            'jumlahMataKuliah' => $jumlahMataKuliah,
            'jumlahKelompok' => $jumlahKelompok,
            'rankedMahasiswas' => $rankedMahasiswas,
            'rankedKelompoks' => $rankedKelompoks,
        ]);
    }
}