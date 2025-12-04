<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Logbook;
use App\Models\PeerReview; // <-- Kita sudah panggil di sini
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
        
        $kelasYangDiajar = $dosen->mataKuliahs()->distinct()->pluck('kelas');
        
        $mahasiswas = User::where('role', 'mahasiswa')
                           ->whereIn('kelas', $kelasYangDiajar)
                           ->with('peerReviewsReceived') 
                           ->orderBy('kelas')->orderBy('name')
                           ->get();

        return view('dosen.rekap.penilaian_sejawat', ['mahasiswas' => $mahasiswas]);
    }

    /**
     * Menampilkan detail penilaian sejawat untuk satu mahasiswa tertentu.
     */
    public function rekapPenilaianSejawatDetail($id): View
    {
        // 1. Ambil data mahasiswa yang ingin dilihat
        $mahasiswa = User::where('role', 'mahasiswa')->findOrFail($id);

        // 2. Ambil semua review yang DITERIMA oleh mahasiswa ini
        // PERBAIKAN: Hapus "\App\Models\" karena sudah di-use di atas
        $reviews = PeerReview::where('reviewed_id', $id) 
                    ->with('reviewer')
                    ->orderBy('minggu_ke', 'asc')
                    ->get()
                    ->groupBy('minggu_ke');

        return view('dosen.rekap.penilaian_sejawat_detail', [
            'mahasiswa' => $mahasiswa,
            'reviewsPerWeek' => $reviews, 
        ]);
    }
}