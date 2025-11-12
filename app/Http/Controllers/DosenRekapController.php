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


    public function showDetailPenilaianSejawat($id): View
    {
        // 1. Ambil data mahasiswa yang ingin dilihat
        $mahasiswa = User::where('role', 'mahasiswa')->findOrFail($id);

        // 2. Ambil semua review yang DITERIMA oleh mahasiswa ini
        //    Kita juga 'with('reviewer')' untuk mendapat NAMA yang memberi nilai
        //    Relasi 'reviewer' ada di model PeerReview
        $reviews = $mahasiswa->peerReviewsReceived() // Relasi dari model User
                            ->with('reviewer')
                            ->orderBy('minggu_ke', 'asc')
                            ->orderBy('created_at', 'asc')
                            ->get()
                            ->groupBy('minggu_ke'); // Kelompokkan hasilnya per minggu

        return view('dosen.rekap.penilaian_sejawat_detail', [
            'mahasiswa' => $mahasiswa,
            'reviewsPerMinggu' => $reviews,
        ]);
    }
}