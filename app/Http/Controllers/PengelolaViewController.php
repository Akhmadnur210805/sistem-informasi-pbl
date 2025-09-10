<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengelolaViewController extends Controller
{
    /**
     * Menampilkan halaman daftar mahasiswa (read-only) dengan filter.
     */
    public function showMahasiswa(Request $request): View
    {
        // Ambil daftar kelas yang ada untuk mengisi dropdown filter
        $kelasList = User::where('role', 'mahasiswa')->whereNotNull('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        // Ambil input kelas yang dipilih dari URL
        $selectedKelas = $request->input('kelas');

        // Mulai query untuk mengambil data mahasiswa
        $query = User::where('role', 'mahasiswa');

        // Jika ada kelas yang dipilih, tambahkan filter ke query
        if ($selectedKelas) {
            $query->where('kelas', $selectedKelas);
        }

        // Eksekusi query untuk mendapatkan hasil akhir
        $mahasiswas = $query->orderBy('name', 'asc')->get();

        // Kirim semua data yang diperlukan ke view
        return view('pengelola.mahasiswa.index', [
            'mahasiswas' => $mahasiswas,
            'kelasList' => $kelasList,
            'selectedKelas' => $selectedKelas
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