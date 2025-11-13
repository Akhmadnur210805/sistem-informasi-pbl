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
        // --- PENGATURAN BOBOT (Silakan disesuaikan) ---
        // Ini untuk Peringkat Mahasiswa. Total harus 1.0
        $bobot_matkul = 0.5; // 50%
        $bobot_sejawat = 0.3; // 30%
        $bobot_presentasi = 0.2; // 20% (Data belum ada)
        
        
        // --- PERINGKAT MAHASISWA (Logika SAW Baru) ---

        // 1. Ambil semua data mahasiswa beserta relasi nilainya
        $mahasiswas = User::where('role', 'mahasiswa')
                          ->with('penilaians', 'peerReviewsReceived') // Ambil data nilai
                          ->get();

        // 2. Hitung skor akhir untuk setiap mahasiswa
        $rankedMahasiswas = $mahasiswas->map(function ($mahasiswa) use ($bobot_matkul, $bobot_sejawat, $bobot_presentasi) {
            
            // Kriteria 1: Nilai Rata-rata Mata Kuliah (skala 0-100)
            $skor_matkul = $mahasiswa->penilaians->avg('nilai') ?? 0;
            
            // Kriteria 2: Nilai Rata-rata Teman Sejawat (skala 1-5, diubah ke 0-100)
            $skor_sejawat_raw = $mahasiswa->peerReviewsReceived->avg('rating') ?? 0;
            $skor_sejawat = $skor_sejawat_raw * 20; // Konversi (1-5) menjadi (20-100)
            
            // Kriteria 3: Nilai Presentasi (BELUM ADA)
            // TODO: Ganti '0' ini dengan query ke data nilai presentasi setelah kita membuatnya
            $skor_presentasi = 0; 
            
            // Hitung Skor Akhir (Weighted Average)
            $skor_akhir = ($skor_matkul * $bobot_matkul) + 
                          ($skor_sejawat * $bobot_sejawat) + 
                          ($skor_presentasi * $bobot_presentasi);
            
            // Simpan skor akhir ke objek mahasiswa
            $mahasiswa->skor_akhir_mahasiswa = $skor_akhir;
            return $mahasiswa;
        });

        // 3. Urutkan mahasiswa berdasarkan skor akhir
        $rankedMahasiswas = $rankedMahasiswas->sortByDesc('skor_akhir_mahasiswa');


        // --- PERINGKAT KELOMPOK (Logika Lama) ---

        // TODO: Logika ini masih menggunakan cara lama (rata-rata nilai matkul)
        // Ini harus diganti total setelah kita membuat tabel 'penilaian_kelompok'
        // untuk kriteria 'Hasil Proyek', 'Kerja Sama', dan 'Presentasi Kelompok'.
        $kelompoks = User::where('role', 'mahasiswa')
                        ->whereNotNull('kelompok')
                        ->leftJoin('penilaians', 'users.id', '=', 'penilaians.user_id')
                        ->select('users.kelompok', 'users.kelas', DB::raw('AVG(penilaians.nilai) as rata_rata_nilai'))
                        ->groupBy('users.kelompok', 'users.kelas')
                        ->orderByDesc('rata_rata_nilai')
                        ->get();
        
        
        // --- PENGIRIMAN DATA KE VIEW ---
        $data = [
            'mahasiswas' => $rankedMahasiswas,
            'kelompoks' => $kelompoks,
        ];

        // Cek peran user dan tampilkan view yang sesuai
        if (Auth::user()->role == 'admin') {
            return view('admin.ranking.index', $data);
        }

        if (Auth::user()->role == 'dosen') {
            return view('dosen.ranking.index', $data);
        }

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