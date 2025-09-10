<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RekapNilaiController extends Controller
{
    public function index(Request $request): View
    {
        // Ambil data untuk filter dropdown
        $mataKuliahs = MataKuliah::orderBy('nama_mk')->get();
        $kelasList = User::where('role', 'mahasiswa')->whereNotNull('kelas')->distinct()->pluck('kelas');
        // Ambil daftar kelompok unik untuk filter (BARIS BARU)
        $kelompokList = User::where('role', 'mahasiswa')->whereNotNull('kelompok')->distinct()->pluck('kelompok');

        // Ambil input dari filter
        $selectedMataKuliahId = $request->input('mata_kuliah_id');
        $selectedKelas = $request->input('kelas');
        $selectedKelompok = $request->input('kelompok'); // <-- Variabel baru

        // Query dasar untuk mengambil nilai
        $query = User::where('role', 'mahasiswa')
                    ->leftJoin('penilaians', 'users.id', '=', 'penilaians.user_id')
                    ->select('users.name as nama_mahasiswa', 'users.kode_admin as nim', 'users.kelas', 'users.kelompok', 'penilaians.nilai');
        
        // Terapkan filter jika ada
        if ($selectedMataKuliahId) {
            $query->where('penilaians.mata_kuliah_id', $selectedMataKuliahId);
        }
        if ($selectedKelas) {
            $query->where('users.kelas', $selectedKelas);
        }
        if ($selectedKelompok) { // <-- Logika filter baru
            $query->where('users.kelompok', $selectedKelompok);
        }

        $rekapNilai = $query->orderBy('users.kelas')->orderBy('users.name')->get();

        return view('pengelola.rekap_nilai.index', [
            'mataKuliahs' => $mataKuliahs,
            'kelasList' => $kelasList,
            'kelompokList' => $kelompokList, // <-- Kirim data baru
            'rekapNilai' => $rekapNilai,
            'selectedMataKuliahId' => $selectedMataKuliahId,
            'selectedKelas' => $selectedKelas,
            'selectedKelompok' => $selectedKelompok, // <-- Kirim data baru
        ]);
    }
}