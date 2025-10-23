<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Logbook;
use App\Models\PeerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DosenRekapController extends Controller
{
    /**
     * Menampilkan rekapitulasi logbook dari mahasiswa yang diajar.
     */
    public function rekapLogbook(): View
    {
        $dosen = Auth::user();

        // 1. Ambil semua kelas unik yang diajar oleh dosen
        // PERBAIKAN: Menggunakan 'kelas' bukan 'pivot_kelas'
        $kelasYangDiajar = $dosen->mataKuliahs()->distinct()->pluck('kelas');

        // 2. Ambil semua mahasiswa dari kelas-kelas tersebut
        $mahasiswas = User::where('role', 'mahasiswa')
                            ->whereIn('kelas', $kelasYangDiajar)
                            ->with(['logbooks' => function ($query) {
                                $query->orderBy('minggu_ke', 'asc');
                            }])
                            ->orderBy('kelas')->orderBy('kelompok')->orderBy('name')
                            ->get()
                            ->groupBy(['kelas', 'kelompok']);

        return view('dosen.rekap.logbook', ['mahasiswaPerKelompok' => $mahasiswas]);
    }

    /**
     * Menampilkan rekapitulasi penilaian sejawat dari mahasiswa yang diajar.
     */
    public function rekapPenilaianSejawat(): View
    {
        $dosen = Auth::user();
        
        // PERBAIKAN: Menggunakan 'kelas' bukan 'pivot_kelas'
        $kelasYangDiajar = $dosen->mataKuliahs()->distinct()->pluck('kelas');
        
        $mahasiswas = User::where('role', 'mahasiswa')
                           ->whereIn('kelas', $kelasYangDiajar)
                           ->with('peerReviewsReceived') // Menggunakan relasi baru
                           ->orderBy('kelas')->orderBy('name')
                           ->get();

        return view('dosen.rekap.penilaian_sejawat', ['mahasiswas' => $mahasiswas]);
    }
}