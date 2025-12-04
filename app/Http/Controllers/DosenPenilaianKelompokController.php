<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PenilaianKelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Tambahkan ini
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DosenPenilaianKelompokController extends Controller
{
    public function index(): View
    {
        $dosen = Auth::user();
        
        // Ambil daftar kelas yang diajar dosen beserta periodenya
        // Format: ['3A' => 'sebelum_uts', '3B' => 'setelah_uts']
        $penugasanDosen = DB::table('dosen_matakuliah')
                            ->where('user_id', $dosen->id)
                            ->select('kelas', 'periode')
                            ->distinct()
                            ->get()
                            ->keyBy('kelas'); // Key array menggunakan nama kelas

        $kelasYangDiajar = $penugasanDosen->keys(); // Ambil daftar nama kelasnya saja
        
        // Ambil kelompok mahasiswa yang ada di kelas tersebut
        $kelompoks = User::where('role', 'mahasiswa')
                        ->whereIn('kelas', $kelasYangDiajar)
                        ->whereNotNull('kelompok')
                        ->select('kelas', 'kelompok')
                        ->distinct()
                        ->orderBy('kelas')->orderBy('kelompok')
                        ->get();

        // Ambil nilai yang sudah ada, TAPI harus cocok dengan periode dosen
        $nilaiSudahAda = collect();
        
        foreach ($kelompoks as $k) {
            // Cek periode untuk kelas ini berdasarkan penugasan dosen
            $periode = $penugasanDosen[$k->kelas]->periode ?? 'sebelum_uts';
            
            $dataNilai = PenilaianKelompok::where('kelas', $k->kelas)
                            ->where('kelompok', $k->kelompok)
                            ->where('periode', $periode) // Filter periode
                            ->first();

            if ($dataNilai) {
                $key = $k->kelas . '|' . $k->kelompok;
                $nilaiSudahAda->put($key, $dataNilai);
            }
        }

        return view('dosen.penilaian_kelompok.index', [
            'kelompoks' => $kelompoks,
            'nilaiSudahAda' => $nilaiSudahAda,
            'penugasanDosen' => $penugasanDosen // Kirim data periode ke view
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'penilaian' => 'required|array',
            'penilaian.*.nilai_hasil_proyek' => 'nullable|integer|min:0|max:100',
            'penilaian.*.nilai_kerja_sama' => 'nullable|integer|min:0|max:100',
            'penilaian.*.nilai_presentasi_kelompok' => 'nullable|integer|min:0|max:100',
        ]);

        $count = 0;
        $dosenId = Auth::user()->id; 

        // Ambil lagi data penugasan untuk memastikan periode yang disimpan benar
        $penugasanDosen = DB::table('dosen_matakuliah')
                            ->where('user_id', $dosenId)
                            ->select('kelas', 'periode')
                            ->distinct()
                            ->get()
                            ->keyBy('kelas');

        foreach ($request->penilaian as $key => $nilai) {
            $parts = explode('|', $key, 2); 
            if (count($parts) < 2) continue; 

            $kelas = $parts[0];
            $kelompok = $parts[1];

            // Ambil periode yang sesuai untuk kelas ini
            $periode = $penugasanDosen[$kelas]->periode ?? null;

            // Hanya simpan jika dosen memang punya penugasan di kelas itu
            if ($periode && ($nilai['nilai_hasil_proyek'] !== null || $nilai['nilai_kerja_sama'] !== null || $nilai['nilai_presentasi_kelompok'] !== null)) {
                
                PenilaianKelompok::updateOrCreate(
                    [
                        'kelas' => $kelas,
                        'kelompok' => $kelompok,
                        'periode' => $periode, // <-- KUNCI: Simpan berdasarkan periode
                    ],
                    [
                        'dosen_id' => $dosenId,
                        'nilai_hasil_proyek' => $nilai['nilai_hasil_proyek'],
                        'nilai_kerja_sama' => $nilai['nilai_kerja_sama'],
                        'nilai_presentasi_kelompok' => $nilai['nilai_presentasi_kelompok'],
                    ]
                );
                $count++;
            }
        }

        if ($count > 0) {
            return back()->with('success', 'Berhasil menyimpan nilai untuk ' . $count . ' kelompok.');
        } else {
            return back()->with('warning', 'Tidak ada data nilai yang disimpan.');
        }
    }
}