<?php

namespace App\Http\Controllers;

use App\Models\PenilaianKelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MahasiswaNilaiController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // 1. Ambil Nilai Individu (Per Mata Kuliah & Periode)
        // Kita urutkan berdasarkan Mata Kuliah agar rapi
        $nilaiIndividu = $user->penilaians()
                              ->with('mataKuliah')
                              ->get()
                              ->sortBy(function($query){
                                  return $query->mataKuliah->nama_mk;
                              });

        // 2. Hitung Rata-rata Nilai Individu untuk Rumus SAW
        // (Digunakan untuk menghitung estimasi skor akhir)
        $avgNilaiProyek = $nilaiIndividu->avg('nilai') ?? 0;
        $avgNilaiPresentasi = $nilaiIndividu->avg('nilai_presentasi') ?? 0;

        // 3. Ambil & Hitung Nilai Teman Sejawat
        $avgRatingSejawat = $user->peerReviewsReceived->avg('rating') ?? 0;
        $skorSejawat = $avgRatingSejawat * 20; // Konversi skala 1-5 ke 0-100

        // 4. Ambil & Hitung Nilai Kelompok
        $nilaiKelompok = null;
        if ($user->kelas && $user->kelompok) {
            // Ambil semua nilai kelompok (UTS + UAS)
            $dataKelompok = PenilaianKelompok::where('kelas', $user->kelas)
                                ->where('kelompok', $user->kelompok)
                                ->get();

            if ($dataKelompok->isNotEmpty()) {
                // Hitung rata-rata dari semua periode
                $nilaiKelompok = [
                    'proyek' => $dataKelompok->avg('nilai_hasil_proyek') ?? 0,
                    'kerjasama' => $dataKelompok->avg('nilai_kerja_sama') ?? 0,
                    'presentasi' => $dataKelompok->avg('nilai_presentasi_kelompok') ?? 0,
                ];
            }
        }

        return view('mahasiswa.nilai.index', [
            'nilais' => $nilaiIndividu,
            'skorSejawat' => $skorSejawat,
            'avgRatingSejawat' => $avgRatingSejawat,
            'nilaiKelompok' => $nilaiKelompok,
            // Kirim data rata-rata untuk simulasi hitungan SAW di view
            'avgIndividu' => [
                'proyek' => $avgNilaiProyek,
                'presentasi' => $avgNilaiPresentasi
            ]
        ]);
    }
}