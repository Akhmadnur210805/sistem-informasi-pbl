<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Support\Str;

class PetugasController extends Controller
{
    /**
     * Dashboard Utama Petugas
     */
    public function dashboard(): View
    {
        $jumlahMustahik = User::where('role', 'mustahik')->count();
        $jumlahPengajuan = Pengajuan::where('status', 'menunggu')->count();
        $jumlahDisetujui = Pengajuan::where('status', 'disetujui')->count();

        $antreanTerbaru = Pengajuan::with(['user', 'kategoriBantuan'])
                                    ->where('status', 'menunggu')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return view('petugas.dashboard', compact(
            'jumlahMustahik', 
            'jumlahPengajuan', 
            'jumlahDisetujui', 
            'antreanTerbaru'
        ));
    }

    /**
     * --- FITUR KELOLA MUSTAHIK ---
     * Menampilkan daftar semua user yang memiliki role 'mustahik'
     */
    public function indexMustahik(Request $request)
    {
        $query = User::where('role', 'mustahik')->withCount('pengajuans');

        // Fitur Pencarian berdasarkan nama atau email
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        $mustahiks = $query->latest()->get();

        // Pastikan folder ini ada: resources/views/petugas/kelola_mustahik/index.blade.php
        return view('petugas.kelola_mustahik.index', compact('mustahiks'));
    }

    /**
     * Menampilkan profil detail seorang Mustahik
     */
    public function showMustahik($id): View
    {
        // Mengambil data user beserta riwayat pengajuannya
        $mustahik = User::with(['pengajuans' => function($query) {
            $query->latest();
        }])->where('role', 'mustahik')->findOrFail($id);

        return view('petugas.kelola_mustahik.show', compact('mustahik'));
    }

    /**
     * Menghapus akun Mustahik
     */
    public function destroyMustahik($id)
    {
        $user = User::where('role', 'mustahik')->findOrFail($id);
        
        // Menghapus user (Pengajuan akan terhapus jika di set cascade pada database)
        $user->delete();

        return redirect()->route('petugas.mustahik.index')
                         ->with('success', 'Data akun mustahik berhasil dihapus dari sistem.');
    }

    /**
     * --- FITUR VERIFIKASI ---
     */
    public function indexVerifikasi(): View
    {
        $pengajuan = Pengajuan::with(['user', 'kategoriBantuan'])
                              ->where('status', 'menunggu')
                              ->latest()
                              ->paginate(10);

        return view('petugas.verifikasi_pengajuan.index', compact('pengajuan'));
    }

    /**
     * Halaman Log Pengajuan (Riwayat Terproses)
     */
    public function logPengajuan(Request $request): View
    {
        $query = Pengajuan::with(['user', 'kategoriBantuan'])
                          ->whereIn('status', ['disetujui', 'ditolak']);

        // Filter Status
        if ($request->filled('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        // Filter Waktu menggunakan Carbon
        if ($request->filled('waktu')) {
            $now = Carbon::now();
            if ($request->waktu == 'bulan_ini') {
                $query->whereMonth('created_at', $now->month)
                      ->whereYear('created_at', $now->year);
            } elseif ($request->waktu == 'bulan_lalu') {
                $query->whereMonth('created_at', $now->copy()->subMonth()->month)
                      ->whereYear('created_at', $now->year);
            } elseif ($request->waktu == 'tahun_ini') {
                $query->whereYear('created_at', $now->year);
            }
        }

        $pengajuan = $query->latest()->paginate(15);

        return view('petugas.verifikasi_pengajuan.log', compact('pengajuan'));
    }

    /**
     * Menampilkan detail pengajuan untuk diverifikasi
     */
    public function showVerifikasi($id): View
    {
        $pengajuan = Pengajuan::with(['user', 'kategoriBantuan'])->findOrFail($id);
        return view('petugas.verifikasi_pengajuan.show', compact('pengajuan'));
    }

    /**
     * Eksekusi Keputusan Verifikasi
     */
    public function prosesVerifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan_petugas' => 'required|string|min:10'
        ], [
            'keterangan_petugas.required' => 'Wajib memberikan catatan alasan verifikasi.',
            'keterangan_petugas.min' => 'Catatan minimal berisi 10 karakter.'
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        
        $pengajuan->update([
            'status' => $request->status,
            'keterangan_petugas' => $request->keterangan_petugas,
            'updated_at' => now(),
        ]);

        return redirect()->route('petugas.log.index')
                         ->with('success', 'Verifikasi Berhasil! Data telah dipindahkan ke Log Riwayat.');
    }

    /**
     * Cetak Profil/Pengajuan ke PDF
     */
    public function downloadProfil($id)
    {
        $pengajuan = Pengajuan::with(['user', 'kategoriBantuan'])->findOrFail($id);
        
        $pdf = Pdf::loadView('petugas.verifikasi_pengajuan.cetak_profil', compact('pengajuan'));
        $pdf->setPaper('a4', 'portrait');

        $safeName = Str::slug($pengajuan->nama_lengkap ?? $pengajuan->user->name, '_');
        
        return $pdf->download('Profil_Mustahik_' . $safeName . '.pdf');
    }
}