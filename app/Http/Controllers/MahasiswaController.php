<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Logbook;
use App\Models\Penilaian;
use Carbon\Carbon;

class MahasiswaController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // 1. Statistik Cepat
        $totalLogbook = Logbook::where('user_id', $user->id)->count();
        $totalMatkulDinilai = Penilaian::where('user_id', $user->id)->count();
        
        // 2. Cek Deadline Logbook (Misal: Deadline setiap hari Minggu)
        $hariIni = Carbon::now();
        $deadlineTerdekat = Carbon::now()->endOfWeek(Carbon::SUNDAY);
        $sisaHari = $hariIni->diffInDays($deadlineTerdekat);

        // 3. Ambil Ranking User Ini (Logika sederhana untuk dashboard)
        // Kita ambil skor akhir dia dari perhitungan controller sebelumnya (disimulasikan di sini)
        // Agar cepat, kita ambil rata-rata nilai proyek saja sebagai gambaran
        $nilaiSementara = $user->penilaians()->avg('nilai') ?? 0;

        return view('mahasiswa.dashboard', [
            'user' => $user,
            'totalLogbook' => $totalLogbook,
            'totalMatkulDinilai' => $totalMatkulDinilai,
            'deadlineTerdekat' => $deadlineTerdekat,
            'sisaHari' => $sisaHari,
            'nilaiSementara' => $nilaiSementara
        ]);
    }
}