<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage; // <-- Pastikan ini ada

class TugasController extends Controller
{
    public function index(): View
    {
        $mataKuliahs = MataKuliah::with(['pengumpulans' => function ($query) {
            $query->where('user_id', Auth::id());
        }])->orderBy('kode_mk', 'asc')->get();
        
        return view('mahasiswa.tugas.index', ['mataKuliahs' => $mataKuliahs]);
    }

    public function uploadTugas(Request $request): RedirectResponse
    {
        $request->validate([
            'file_tugas' => 'required|file|mimes:pdf,doc,docx,zip|max:10240', // Maks 10MB
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id'
        ]);

        $file = $request->file('file_tugas');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        
        // --- LOGIKA PENYIMPANAN YANG DIPERBARUI ---
        // Simpan file ke dalam folder 'tugas' di dalam disk 'public' (yang mengarah ke storage/app/public)
        $path = Storage::disk('public')->putFileAs('tugas', $file, $namaFile);

        Pengumpulan::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'mata_kuliah_id' => $request->mata_kuliah_id,
            ],
            [
                'nama_file' => $namaFile,
                'path_file' => $path,
            ]
        );

        return back()->with('success', 'File tugas berhasil diunggah.');
    }
}