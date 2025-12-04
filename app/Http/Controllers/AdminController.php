<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MataKuliah;
use App\Models\PenilaianKelompok;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $jumlahMahasiswa = User::where('role','mahasiswa')->count();
        $jumlahDosen = User::where('role','dosen')->count();
        $jumlahPengelola = User::where('role','pengelola')->count();
        $jumlahMataKuliah = MataKuliah::count();

        $w_matkul = 0.50; $w_presentasi = 0.20; $w_sejawat = 0.30;
        $w_proyek = 0.50; $w_kerjasama = 0.30; $w_pres_kel = 0.20;

        $rankedMahasiswas = User::where('role','mahasiswa')
            ->with(['penilaians','peerReviewsReceived'])
            ->get()
            ->map(function ($mhs) use ($w_matkul, $w_presentasi, $w_sejawat) {
                $c1 = $mhs->penilaians->avg('nilai') ?? 0;
                $c2 = $mhs->penilaians->avg('nilai_presentasi') ?? 0;
                $c3 = ($mhs->peerReviewsReceived->avg('rating') ?? 0) * 20;

                $mhs->skor_akhir = ($c1*$w_matkul)+($c2*$w_presentasi)+($c3*$w_sejawat);
                return $mhs;
            })->sortByDesc('skor_akhir')->take(5);

        $rankedKelompoks = PenilaianKelompok::all()->groupBy(function($item){
            return $item->kelas.'-'.$item->kelompok;
        })->map(function ($group) use ($w_proyek,$w_kerjasama,$w_pres_kel){
            $rep = $group->first();
            $rep->skor_akhir =
                ($group->avg('nilai_hasil_proyek')??0)*$w_proyek +
                ($group->avg('nilai_kerja_sama')??0)*$w_kerjasama +
                ($group->avg('nilai_presentasi_kelompok')??0)*$w_pres_kel;
            return $rep;
        })->sortByDesc('skor_akhir')->take(5);

        return view('admin.dashboard', compact(
            'jumlahMahasiswa','jumlahDosen','jumlahPengelola',
            'jumlahMataKuliah','rankedMahasiswas','rankedKelompoks'
        ));
    }
}
