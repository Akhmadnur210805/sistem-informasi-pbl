<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan; 
use App\Models\KategoriBantuan; 
use Barryvdh\DomPDF\Facade\Pdf; 
use Carbon\Carbon;

class PimpinanController extends Controller
{
    // 1. Menampilkan Halaman Dashboard Utama
    public function dashboard()
    {
        // Menghitung data statistik dari database
        $totalPengajuan = Pengajuan::count();
        $pengajuanMenunggu = Pengajuan::where('status', 'menunggu')->count();
        $pengajuanDisetujui = Pengajuan::where('status', 'disetujui')->count();
        $pengajuanDitolak = Pengajuan::where('status', 'ditolak')->count();

        // Mengirimkan data variabel ke tampilan dashboard
        return view('pimpinan.dashboard', compact(
            'totalPengajuan', 
            'pengajuanMenunggu', 
            'pengajuanDisetujui', 
            'pengajuanDitolak'
        ));
    }

    // 2. Menampilkan Halaman Form Cetak Laporan (View: index.blade.php)
    public function indexLaporan()
    {
        // Ambil data kategori yang aktif untuk pilihan di dropdown filter
        $kategoriBantuan = KategoriBantuan::where('is_active', true)->get();
        
        return view('pimpinan.laporan.index', compact('kategoriBantuan'));
    }

    // 3. Proses Filter Data dan Generate PDF (View: pdf.blade.php)
    public function cetakLaporan(Request $request)
    {
        // Validasi input tanggal dari form Pimpinan
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ], [
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_akhir.required' => 'Tanggal akhir wajib diisi.',
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir tidak boleh lebih kecil dari tanggal mulai.'
        ]);

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;
        $status = $request->status; 
        $kategori_id = $request->kategori_id; 

        // Mulai merakit Query Pencarian Data (Hanya memanggil relasi Kategori agar ringan)
        $query = Pengajuan::with(['kategoriBantuan']);

        // Filter Rentang Tanggal menggunakan startOfDay dan endOfDay agar sangat akurat
        $query->whereBetween('created_at', [
            Carbon::parse($tanggalMulai)->startOfDay(), 
            Carbon::parse($tanggalAkhir)->endOfDay()
        ]);

        // Jika pimpinan memfilter status tertentu (tidak memilih "Semua")
        if ($status && $status != 'semua') {
            $query->where('status', $status);
        }

        // Jika pimpinan memfilter program tertentu (tidak memilih "Semua")
        if ($kategori_id && $kategori_id != 'semua') {
            $query->where('kategori_bantuan_id', $kategori_id);
        }

        // Eksekusi pencarian data dan urutkan dari yang paling baru
        $pengajuan = $query->orderBy('created_at', 'desc')->get();

        // Data yang dikirim ke kerangka HTML PDF
        $data = [
            'pengajuan' => $pengajuan,
            'tanggalMulai' => Carbon::parse($tanggalMulai)->translatedFormat('d F Y'),
            'tanggalAkhir' => Carbon::parse($tanggalAkhir)->translatedFormat('d F Y'),
            'statusFilter' => $status == 'semua' ? 'Semua Status' : ucfirst($status),
        ];

        // Konfigurasi Kertas (A4 posisi Horizontal/Landscape)
        $pdf = Pdf::loadView('pimpinan.laporan.pdf', $data)->setPaper('a4', 'landscape');

        // Buka PDF langsung di tab baru browser dengan nama file yang memuat timestamp
        $namaFile = 'Laporan-Pengajuan-SIMPATIK-' . time() . '.pdf';
        return $pdf->stream($namaFile);
    }
}