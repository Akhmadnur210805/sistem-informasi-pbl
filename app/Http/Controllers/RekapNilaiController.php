<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MataKuliah;
use App\Models\PenilaianKelompok;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapNilaiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Data untuk Dropdown Filter
        $kelasList = User::where('role', 'mahasiswa')->distinct()->pluck('kelas')->sort();
        
        // Ambil daftar Angkatan (urut dari terbaru)
        $angkatanList = User::where('role', 'mahasiswa')
                            ->whereNotNull('angkatan')
                            ->distinct()
                            ->pluck('angkatan')
                            ->sortDesc();

        // 2. Query Dasar
        $query = User::where('role', 'mahasiswa')
                     ->with(['penilaians', 'peerReviewsReceived']);

        // --- LOGIKA FILTER ---
        
        // Filter Kelas
        if ($request->has('kelas') && $request->kelas != 'Semua Kelas') {
            $query->where('kelas', $request->kelas);
        }

        // Filter Angkatan (Fitur Baru)
        if ($request->has('angkatan') && $request->angkatan != 'Semua Angkatan') {
            $query->where('angkatan', $request->angkatan);
        }
        
        // Ambil data mahasiswa
        $mahasiswas = $query->orderBy('kelas')->orderBy('name')->get();

        // 3. Hitung Nilai Final (Metode SAW)
        $rekapData = $this->hitungNilaiSAW($mahasiswas);

        return view('pengelola.rekap_nilai.index', [
            'mahasiswas' => $rekapData,
            'kelasList' => $kelasList,
            'angkatanList' => $angkatanList, // Kirim data angkatan ke view
            'selectedKelas' => $request->kelas ?? 'Semua Kelas',
            'selectedAngkatan' => $request->angkatan ?? 'Semua Angkatan'
        ]);
    }

    public function downloadPDF(Request $request)
    {
        // Query yang sama persis dengan index untuk PDF
        $query = User::where('role', 'mahasiswa')
                     ->with(['penilaians', 'peerReviewsReceived']);

        if ($request->has('kelas') && $request->kelas != 'Semua Kelas') {
            $query->where('kelas', $request->kelas);
        }
        
        if ($request->has('angkatan') && $request->angkatan != 'Semua Angkatan') {
            $query->where('angkatan', $request->angkatan);
        }

        $mahasiswas = $query->orderBy('kelas')->orderBy('name')->get();
        $rekapData = $this->hitungNilaiSAW($mahasiswas);

        // Load View PDF
        $pdf = Pdf::loadView('pengelola.rekap_nilai.pdf', [
            'mahasiswas' => $rekapData,
            'kelas' => $request->kelas ?? 'Semua Kelas',
            'angkatan' => $request->angkatan ?? 'Semua Angkatan'
        ]);

        return $pdf->download('Rekap_Nilai_PBL.pdf');
    }

    /**
     * Fungsi Privat: Perhitungan SAW (Bobot dan Kriteria)
     */
    private function hitungNilaiSAW($mahasiswas)
    {
        // Ambil semua data nilai kelompok untuk referensi cepat
        $allNilaiKelompok = PenilaianKelompok::all()->keyBy(function($item) {
            return $item['kelas'] . '-' . $item['kelompok'];
        });

        return $mahasiswas->map(function ($mhs) use ($allNilaiKelompok) {
            // --- SAW INDIVIDU (Bobot: 50%, 20%, 30%) ---
            $c1 = $mhs->penilaians->avg('nilai') ?? 0;            // Matkul
            $c2 = $mhs->penilaians->avg('nilai_presentasi') ?? 0; // Presentasi
            $avgRating = $mhs->peerReviewsReceived->avg('rating') ?? 0;
            $c3 = $avgRating * 20;                                // Sejawat

            $skorIndividu = ($c1 * 0.50) + ($c2 * 0.20) + ($c3 * 0.30);

            // --- SAW KELOMPOK (Bobot: 50%, 30%, 20%) ---
            $skorKelompok = 0;
            if ($mhs->kelas && $mhs->kelompok) {
                $key = $mhs->kelas . '-' . $mhs->kelompok;
                
                // Cari nilai kelompok yang cocok (bisa lebih dari 1 jika ada UTS/UAS, kita ambil rata-rata)
                // Karena keyBy hanya ambil satu, kita perlu filter manual dari collection asli untuk lebih akurat jika ada duplikat
                $dataKelompok = PenilaianKelompok::where('kelas', $mhs->kelas)
                                                ->where('kelompok', $mhs->kelompok)
                                                ->get();

                if ($dataKelompok->isNotEmpty()) {
                    $k1 = $dataKelompok->avg('nilai_hasil_proyek') ?? 0;
                    $k2 = $dataKelompok->avg('nilai_kerja_sama') ?? 0;
                    $k3 = $dataKelompok->avg('nilai_presentasi_kelompok') ?? 0;
                    
                    $skorKelompok = ($k1 * 0.50) + ($k2 * 0.30) + ($k3 * 0.20);
                }
            }

            // Simpan hasil format desimal
            $mhs->nilai_akhir_individu = number_format($skorIndividu, 2);
            $mhs->nilai_akhir_kelompok = number_format($skorKelompok, 2);
            
            return $mhs;
        });
    }
}