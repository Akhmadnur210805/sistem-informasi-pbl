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
        $dosen_id = Auth::id();

        $isAuthorized = DB::table('dosen_matakuliah')
            ->where('user_id', $dosen_id)
            ->where('mata_kuliah_id', $matakuliah->id)
            ->whereRaw('UPPER(kelas) = ?', [strtoupper($kelas)])
            ->exists();

        if (!$isAuthorized) {
            abort(403, 'ANDA TIDAK BERHAK MENGAKSES HALAMAN INI.');
        }

        $mahasiswas = User::where('role', 'mahasiswa')
                            ->where('kelas', $kelas)
                            ->orderBy('kelompok', 'asc')
                            ->get();

        $kelompoks = $mahasiswas->groupBy('kelompok');

        return view('dosen.penilaian.form', [
            'matakuliah' => $matakuliah,
            'kelas' => $kelas,
            'kelompoks' => $kelompoks
        ]);
    }

    public function storePenilaian(Request $request, MataKuliah $matakuliah, $kelas): RedirectResponse
    {
        $dosen_id = Auth::id();
        
        $isAuthorized = DB::table('dosen_matakuliah')
            ->where('user_id', $dosen_id)
            ->where('mata_kuliah_id', $matakuliah->id)
            ->whereRaw('UPPER(kelas) = ?', [strtoupper($kelas)])
            ->exists();

        if (!$isAuthorized) {
            abort(403, 'ANDA TIDAK BERHAK MENYIMPAN NILAI UNTUK PENUGASAN INI.');
        }
        
        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|integer|min:0|max:100',
        ]);

        foreach ($request->nilai as $mahasiswaId => $nilai) {
            if (!is_null($nilai)) {
                Penilaian::updateOrCreate(
                    ['user_id' => $mahasiswaId, 'mata_kuliah_id' => $matakuliah->id],
                    ['nilai' => $nilai]
                );
            }
        }

        return redirect()->route('dosen.penilaian.index')->with('success', 'Nilai untuk ' . $matakuliah->nama_mk . ' di kelas ' . $kelas . ' berhasil disimpan.');
    }
}