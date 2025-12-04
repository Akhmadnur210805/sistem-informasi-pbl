<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MataKuliah;
use App\Models\PenilaianKelompok;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class RankingController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = Auth::user(); // Ambil user yang sedang login

        // 1. Ambil Data Filter (Hanya dipakai Admin/Pengelola/Dosen)
        $kelasList = User::where('role', 'mahasiswa')->distinct()->pluck('kelas')->sort();
        $angkatanList = User::where('role', 'mahasiswa')->whereNotNull('angkatan')->distinct()->pluck('angkatan')->sortDesc();

        // ==========================================
        // 2. PERINGKAT MAHASISWA (SAW)
        // ==========================================
        $queryMhs = User::where('role', 'mahasiswa')->with(['penilaians', 'peerReviewsReceived']);

        // --- LOGIKA FILTER POV (TETAP ADA) ---
        if ($user->role == 'mahasiswa') {
            // JIKA MAHASISWA: Kunci hanya ke angkatan dia sendiri
            $queryMhs->where('angkatan', $user->angkatan);
        } else {
            // JIKA ADMIN/DOSEN/PENGELOLA: Gunakan filter dari dropdown
            if ($request->has('kelas') && $request->kelas != 'Semua Kelas') {
                $queryMhs->where('kelas', $request->kelas);
            }
            if ($request->has('angkatan') && $request->angkatan != 'Semua Angkatan') {
                $queryMhs->where('angkatan', $request->angkatan);
            }
        }
        
        $mahasiswas = $queryMhs->get();

        // --- PERBAIKAN HITUNGAN (KEMBALI KE RATA-RATA / AVG) ---
        $w_matkul = 0.50; $w_presentasi = 0.20; $w_sejawat = 0.30;
        
        $rankedMahasiswas = $mahasiswas->map(function ($mahasiswa) use ($w_matkul, $w_presentasi, $w_sejawat) {
            // Gunakan AVG (Rata-rata) agar nilai sesuai harapan (skala 0-100)
            // Bukan dibagi total matkul
            $c1 = $mahasiswa->penilaians->avg('nilai') ?? 0;
            $c2 = $mahasiswa->penilaians->avg('nilai_presentasi') ?? 0;
            
            $avgRating = $mahasiswa->peerReviewsReceived->avg('rating') ?? 0;
            $c3 = $avgRating * 20; 

            $mahasiswa->skor_akhir_mahasiswa = ($c1 * $w_matkul) + ($c2 * $w_presentasi) + ($c3 * $w_sejawat);
            return $mahasiswa;
        })->sortByDesc('skor_akhir_mahasiswa')->values();


        // ==========================================
        // 3. PERINGKAT KELOMPOK (SAW)
        // ==========================================
        $w_proyek = 0.50; $w_kerjasama = 0.30; $w_pres_kel = 0.20;
        
        $dataKelompok = PenilaianKelompok::all();

        $rankedKelompoks = $dataKelompok->groupBy(function ($item) {
            return $item->kelas . '-' . $item->kelompok;
        })->map(function ($group) use ($w_proyek, $w_kerjasama, $w_pres_kel) {
            $rep = $group->first();
            
            // Cari angkatan kelompok ini
            $anggota = User::where('kelas', $rep->kelas)
                           ->where('kelompok', $rep->kelompok)
                           ->where('role', 'mahasiswa')
                           ->first();
            $rep->angkatan = $anggota ? $anggota->angkatan : '-';

            // Hitung rata-rata kelompok
            $c1 = $group->avg('nilai_hasil_proyek') ?? 0;
            $c2 = $group->avg('nilai_kerja_sama') ?? 0;
            $c3 = $group->avg('nilai_presentasi_kelompok') ?? 0;

            $rep->skor_akhir = ($c1 * $w_proyek) + ($c2 * $w_kerjasama) + ($c3 * $w_pres_kel);
            
            return $rep;
        })
        // --- FILTER OTOMATIS KELOMPOK ---
        ->filter(function ($item) use ($request, $user) {
            if ($user->role == 'mahasiswa') {
                return $item->angkatan == $user->angkatan;
            } else {
                $passKelas = true;
                $passAngkatan = true;
                if ($request->has('kelas') && $request->kelas != 'Semua Kelas') $passKelas = ($item->kelas == $request->kelas);
                if ($request->has('angkatan') && $request->angkatan != 'Semua Angkatan') $passAngkatan = ($item->angkatan == $request->angkatan);
                return $passKelas && $passAngkatan;
            }
        })
        ->sortByDesc('skor_akhir')->values();


        // 4. PENGIRIMAN DATA
        $data = [
            'mahasiswas' => $rankedMahasiswas,
            'kelompoks' => $rankedKelompoks,
            'kelasList' => $kelasList,
            'angkatanList' => $angkatanList,
            'selectedKelas' => $request->kelas ?? 'Semua Kelas',
            'selectedAngkatan' => $request->angkatan ?? 'Semua Angkatan'
        ];

        if ($user->role == 'admin') return view('admin.ranking.index', $data);
        if ($user->role == 'dosen') return view('dosen.ranking.index', $data);
        if ($user->role == 'pengelola') return view('pengelola.ranking.index', $data);
        if ($user->role == 'mahasiswa') return view('mahasiswa.ranking.index', $data);

        return redirect()->back();
    }
}