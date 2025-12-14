<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Logbook;
use App\Models\Penilaian;
use App\Models\Agenda; // <--- Pastikan Model Agenda sudah dibuat
use Carbon\Carbon;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan Dashboard Mahasiswa + Data Kanban Board
     */
    public function index(): View
    {
        $user = Auth::user();

        // 1. Statistik Logbook & Penilaian
        $totalLogbook = Logbook::where('user_id', $user->id)->count();
        $totalMatkulDinilai = Penilaian::where('user_id', $user->id)->count();
        
        // 2. Cek Deadline (Minggu ini)
        $hariIni = Carbon::now();
        $deadlineTerdekat = Carbon::now()->endOfWeek(Carbon::SUNDAY);
        $sisaHari = $hariIni->diffInDays($deadlineTerdekat);

        // 3. Estimasi Ranking (Rata-rata Nilai)
        $nilaiSementara = $user->penilaians()->avg('nilai') ?? 0;

        // 4. Data Agenda (Kanban Board)
        $todo    = Agenda::where('status', 'todo')->orderBy('created_at', 'desc')->get();
        $process = Agenda::where('status', 'process')->orderBy('created_at', 'desc')->get();
        $done    = Agenda::where('status', 'done')->orderBy('created_at', 'desc')->get();

        return view('mahasiswa.dashboard', [
            'user' => $user,
            'totalLogbook' => $totalLogbook,
            'totalMatkulDinilai' => $totalMatkulDinilai,
            'deadlineTerdekat' => $deadlineTerdekat,
            'sisaHari' => $sisaHari,
            'nilaiSementara' => $nilaiSementara,
            'todo' => $todo,
            'process' => $process,
            'done' => $done
        ]);
    }

    /**
     * Menyimpan Agenda Baru (Create)
     */
    public function storeAgenda(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date',
            'prioritas' => 'required',
        ]);

        Agenda::create([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline'  => $request->deadline,
            'prioritas' => $request->prioritas,
            'status'    => 'todo', // Default status: Rencana
            // 'user_id' => Auth::id() // Aktifkan jika tabel agenda punya kolom user_id
        ]);

        return redirect()->back()->with('success', 'Tugas baru berhasil ditambahkan!');
    }

    /**
     * Update Status Agenda (Move Card)
     */
    public function updateStatus(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);
        
        // Update status sesuai input tombol (process/done/todo)
        $agenda->status = $request->status;
        $agenda->save();

        return redirect()->back()->with('success', 'Status tugas diperbarui!');
    }

    /**
     * Hapus Agenda (Delete)
     */
    public function deleteAgenda($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return redirect()->back()->with('success', 'Tugas dihapus dari papan.');
    }
}