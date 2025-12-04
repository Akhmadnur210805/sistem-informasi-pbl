<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\User;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DosenPenilaianController extends Controller
{
    public function index(): View
    {
        $dosen = Auth::user();
        $penugasans = $dosen->mataKuliahs;
        return view('dosen.penilaian.index', ['penugasans' => $penugasans]);
    }

    public function showPenilaianForm(MataKuliah $matakuliah, $kelas): View
    {
        $dosen_id = Auth::user()->id;

        // 1. Ambil data penugasan untuk mengetahui PERIODE dosen ini
        $penugasan = DB::table('dosen_matakuliah')
            ->where('user_id', $dosen_id)
            ->where('mata_kuliah_id', $matakuliah->id)
            ->whereRaw('UPPER(kelas) = ?', [strtoupper($kelas)])
            ->first(); // Ambil baris datanya

        if (!$penugasan) {
            abort(403, 'ANDA TIDAK BERHAK MENGAKSES HALAMAN INI.');
        }
        
        // Simpan periode dosen ini (sebelum_uts / setelah_uts)
        $periodeDosen = $penugasan->periode;

        $mahasiswas = User::where('role', 'mahasiswa')
                            ->where('kelas', $kelas)
                            ->orderBy('kelompok', 'asc')
                            ->get();

        // 2. Ambil nilai HANYA untuk periode dosen tersebut
        $nilaiSudahAda = Penilaian::where('mata_kuliah_id', $matakuliah->id)
                                ->where('periode', $periodeDosen) // <-- FILTER PENTING
                                ->whereIn('user_id', $mahasiswas->pluck('id'))
                                ->get()
                                ->keyBy('user_id');

        $kelompoks = $mahasiswas->groupBy('kelompok');

        return view('dosen.penilaian.form', [
            'matakuliah' => $matakuliah,
            'kelas' => $kelas,
            'kelompoks' => $kelompoks,
            'nilaiSudahAda' => $nilaiSudahAda
        ]);
    }

    public function storePenilaian(Request $request, MataKuliah $matakuliah, $kelas): RedirectResponse
    {
        $dosen_id = Auth::user()->id;
        
        // 1. Cek Penugasan & Ambil Periode
        $penugasan = DB::table('dosen_matakuliah')
            ->where('user_id', $dosen_id)
            ->where('mata_kuliah_id', $matakuliah->id)
            ->whereRaw('UPPER(kelas) = ?', [strtoupper($kelas)])
            ->first();

        if (!$penugasan) {
            abort(403, 'ANDA TIDAK BERHAK MENYIMPAN NILAI UNTUK PENUGASAN INI.');
        }

        $periodeDosen = $penugasan->periode; // Ambil periode (sebelum/setelah uts)
        
        $request->validate([
            'nilai_matkul' => 'array',
            'nilai_matkul.*' => 'nullable|integer|min:0|max:100',
            'nilai_presentasi' => 'array',
            'nilai_presentasi.*' => 'nullable|integer|min:0|max:100',
        ]);

        if ($request->has('nilai_matkul')) {
            foreach ($request->nilai_matkul as $mahasiswaId => $nilaiInput) {
                if ($nilaiInput !== null) {
                    Penilaian::updateOrCreate(
                        [
                            'user_id' => $mahasiswaId,
                            'mata_kuliah_id' => $matakuliah->id,
                            'periode' => $periodeDosen, // <-- KUNCI PERBAIKAN: Simpan berdasarkan periode
                        ],
                        [
                            'nilai' => $nilaiInput,
                            'nilai_presentasi' => $request->nilai_presentasi[$mahasiswaId] ?? null
                        ]
                    );
                }
            }
        }

        return redirect()->route('dosen.penilaian.index')->with('success', 'Nilai untuk ' . $matakuliah->nama_mk . ' (' . ucfirst(str_replace('_', ' ', $periodeDosen)) . ') berhasil disimpan.');
    }
}