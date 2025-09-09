<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\User;
use App\Models\Penilaian; // <-- Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; // <-- Tambahkan ini

class DosenPenilaianController extends Controller
{
    public function index(): View
    {
        $mataKuliahs = MataKuliah::orderBy('kode_mk', 'asc')->get();
        return view('dosen.penilaian.index', ['mataKuliahs' => $mataKuliahs]);
    }

    public function showPenilaianForm(MataKuliah $matakuliah): View
    {
        $mahasiswas = User::where('role', 'mahasiswa')
                            ->whereNotNull('kelompok')
                            ->orderBy('kelas', 'asc')
                            ->orderBy('kelompok', 'asc')
                            ->get();

        $kelompoks = $mahasiswas->groupBy(['kelas', 'kelompok']);

        return view('dosen.penilaian.form', [
            'matakuliah' => $matakuliah,
            'kelompoks' => $kelompoks
        ]);
    }

    /**
     * Menyimpan data penilaian ke database. (FUNGSI BARU)
     */
    public function storePenilaian(Request $request, MataKuliah $matakuliah): RedirectResponse
    {
        // Validasi input: pastikan 'nilai' adalah array, dan setiap isinya adalah angka 0-100
        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|integer|min:0|max:100',
        ]);

        // Looping untuk setiap nilai yang dikirim dari form
        foreach ($request->nilai as $mahasiswaId => $nilai) {
            // Hanya simpan jika nilainya tidak kosong
            if (!is_null($nilai)) {
                // Gunakan updateOrCreate untuk membuat nilai baru atau memperbarui jika sudah ada
                Penilaian::updateOrCreate(
                    [
                        'user_id' => $mahasiswaId,
                        'mata_kuliah_id' => $matakuliah->id,
                    ],
                    [
                        'nilai' => $nilai,
                    ]
                );
            }
        }

        return redirect()->route('dosen.penilaian.index')->with('success', 'Nilai untuk mata kuliah ' . $matakuliah->nama_mk . ' berhasil disimpan.');
    }
}