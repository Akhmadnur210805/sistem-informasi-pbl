<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LogbookController extends Controller
{
    /**
     * Menampilkan halaman logbook dengan riwayat pengumpulan.
     */
    public function index(): View
    {
        // Menggunakan Auth::user()->id untuk memastikan ID numerik yang diambil
        $logbooks = Logbook::where('user_id', Auth::user()->id)
                            ->orderBy('minggu_ke', 'desc')
                            ->get();

        return view('mahasiswa.logbook.index', ['logbooks' => $logbooks]);
    }

    /**
     * Menyimpan data logbook mingguan baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'minggu_ke' => 'required|integer|min:1',
            'deskripsi' => 'required|string|max:1000',
            'file_logbook' => 'nullable|file|mimes:pdf,doc,docx,zip|max:5120', // Maks 5MB
        ]);

        $filePath = null;
        if ($request->hasFile('file_logbook')) {
            // Menggunakan ID numerik pengguna untuk path file
            $filePath = $request->file('file_logbook')->store('logbooks/' . Auth::user()->id, 'public');
        }

        // KODE PALING PENTING: Menggunakan Auth::user()->id yang 100% mengambil ANGKA ID
        Logbook::create([
            'user_id' => Auth::user()->id,
            'minggu_ke' => $request->minggu_ke,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
        ]);

        return redirect()->route('mahasiswa.logbook.index')->with('success', 'Logbook minggu ke-' . $request->minggu_ke . ' berhasil diunggah!');
    }
}