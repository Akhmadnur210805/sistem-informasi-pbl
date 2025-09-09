<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB; // <-- Penting: Tambahkan ini

class RankingController extends Controller
{
    public function index(): View|RedirectResponse
    {
        // --- Mengambil data untuk Ranking Mahasiswa (Semua) ---
        $mahasiswas = User::where('role', 'mahasiswa')
            ->leftJoin('penilaians', 'users.id', '=', 'penilaians.user_id')
            ->select('users.id', 'users.name', 'users.kelas', DB::raw('AVG(penilaians.nilai) as rata_rata_nilai'))
            ->groupBy('users.id', 'users.name', 'users.kelas')
            ->orderByDesc('rata_rata_nilai')
            ->get();

        // --- Mengambil data untuk Ranking Kelompok (Semua) ---
        $kelompoks = User::where('role', 'mahasiswa')
            ->whereNotNull('kelompok')
            ->leftJoin('penilaians', 'users.id', '=', 'penilaians.user_id')
            ->select('users.kelompok', 'users.kelas', DB::raw('AVG(penilaians.nilai) as rata_rata_nilai'))
            ->groupBy('users.kelompok', 'users.kelas')
            ->orderByDesc('rata_rata_nilai')
            ->get();

        // Siapkan data untuk dikirim ke view
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

        // Fallback
        return redirect()->back();
    }
}