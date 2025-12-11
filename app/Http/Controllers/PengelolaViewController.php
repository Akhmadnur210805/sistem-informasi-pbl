<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengelolaViewController extends Controller
{
    /**
     * Menampilkan halaman daftar mahasiswa (read-only) dengan filter Lengkap.
     */
    public function showMahasiswa(Request $request): View
    {
        // 1. Ambil data unik untuk dropdown filter
        $angkatanList = User::where('role', 'mahasiswa')
                            ->whereNotNull('angkatan')
                            ->distinct()
                            ->orderBy('angkatan', 'desc')
                            ->pluck('angkatan');

        $kelasList = User::where('role', 'mahasiswa')
                         ->whereNotNull('kelas')
                         ->distinct()
                         ->orderBy('kelas')
                         ->pluck('kelas');

        $kelompokList = User::where('role', 'mahasiswa')
                            ->whereNotNull('kelompok')
                            ->distinct()
                            ->orderBy('kelompok')
                            ->pluck('kelompok');

        // 2. Ambil input pilihan user dari URL (jika ada)
        $selectedAngkatan = $request->input('angkatan');
        $selectedKelas    = $request->input('kelas');
        $selectedKelompok = $request->input('kelompok');

        // 3. Mulai Query Dasar
        $query = User::where('role', 'mahasiswa');

        // 4. Terapkan Filter jika user memilih sesuatu
        if ($selectedAngkatan) {
            $query->where('angkatan', $selectedAngkatan);
        }

        if ($selectedKelas) {
            $query->where('kelas', $selectedKelas);
        }

        if ($selectedKelompok) {
            $query->where('kelompok', $selectedKelompok);
        }

        // 5. Eksekusi Query
        $mahasiswas = $query->orderBy('kelas', 'asc')
                            ->orderBy('name', 'asc')
                            ->get();

        // 6. Kirim data ke View
        return view('pengelola.mahasiswa.index', [
            'mahasiswas'       => $mahasiswas,
            'angkatanList'     => $angkatanList,
            'kelasList'        => $kelasList,
            'kelompokList'     => $kelompokList,
            'selectedAngkatan' => $selectedAngkatan,
            'selectedKelas'    => $selectedKelas,
            'selectedKelompok' => $selectedKelompok
        ]);
    }

    /**
     * Menampilkan halaman daftar dosen (read-only).
     */
    public function showDosen(): View
    {
        $dosens = User::where('role', 'dosen')->get();
        return view('pengelola.dosen.index', compact('dosens'));
    }
}