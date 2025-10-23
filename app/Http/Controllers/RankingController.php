<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function index(): View|RedirectResponse
    {
        // Logika untuk mengambil data ranking (tetap sama)
        $mahasiswas = User::where('role', 'mahasiswa')
                            ->leftJoin('penilaians', 'users.id', '=', 'penilaians.user_id')
                            ->select('users.id', 'users.name', 'users.kelas', DB::raw('AVG(penilaians.nilai) as rata_rata_nilai'))
                            ->groupBy('users.id', 'users.name', 'users.kelas')
                            ->orderByDesc('rata_rata_nilai')
                            ->get();

        $kelompoks = User::where('role', 'mahasiswa')
                            ->whereNotNull('kelompok')
                            ->leftJoin('penilaians', 'users.id', '=', 'penilaians.user_id')
                            ->select('users.kelompok', 'users.kelas', DB::raw('AVG(penilaians.nilai) as rata_rata_nilai'))
                            ->groupBy('users.kelompok', 'users.kelas')
                            ->orderByDesc('rata_rata_nilai')
                            ->get();
        
        $data = [
            'mahasiswas' => $mahasiswas,
            'kelompoks' => $kelompoks,
        ];

        // Cek peran user dan tampilkan view yang sesuai
        if (Auth::user()->role == 'admin') {
            return view('admin.ranking.index', $data);
        }

        if (Auth::user()->role == 'dosen') {
            return view('dosen.ranking.index', $data);
        }

        // KONDISI BARU UNTUK PENGELOLA
        if (Auth::user()->role == 'pengelola') {
            return view('pengelola.ranking.index', $data);
        }

        if (Auth::user()->role == 'mahasiswa') {
            return view('mahasiswa.ranking.index', $data);
        }

        // Fallback
        return redirect()->back();
    }
}