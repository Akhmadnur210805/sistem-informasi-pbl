<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan; 
use App\Models\KategoriBantuan; 
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf; 
use Carbon\Carbon;

class PimpinanController extends Controller
{
    /**
     * 1. Menampilkan Halaman Dashboard Utama
     */
    public function dashboard()
    {
        $totalPengajuan = Pengajuan::count();
        $pengajuanMenunggu = Pengajuan::where('status', 'menunggu')->count();
        $pengajuanDisetujui = Pengajuan::where('status', 'disetujui')->count();
        $pengajuanDitolak = Pengajuan::where('status', 'ditolak')->count();

        return view('pimpinan.dashboard', compact(
            'totalPengajuan', 
            'pengajuanMenunggu', 
            'pengajuanDisetujui', 
            'pengajuanDitolak'
        ));
    }

    /**
     * 2. Menampilkan Halaman Pantau Data Mustahik
     */
    public function indexMustahik(Request $request)
    {
        $query = Pengajuan::where('status', 'disetujui')
                    ->with(['user', 'kategoriBantuan']);

        $totalMustahik = $query->count();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $dataMustahik = $query->latest()->paginate(10);

        return view('pimpinan.mustahik.index', compact('dataMustahik', 'totalMustahik'));
    }

    /**
     * 3. Menampilkan Halaman Log Aktivitas Petugas
     */
    public function logAktivitas()
    {
        $logs = Pengajuan::whereIn('status', ['disetujui', 'ditolak'])
                ->with(['user', 'kategoriBantuan'])
                ->latest()
                ->paginate(15);

        return view('pimpinan.log_aktivitas', compact('logs'));
    }

    /**
     * 4. Menampilkan Halaman Pengaturan Akun
     */
    public function pengaturanAkun()
    {
        $user = auth()->user();
        return view('pimpinan.pengaturan', compact('user'));
    }

    /**
     * 5. Proses Update Pengaturan Akun (Nama, Email, Password)
     */
    public function updatePengaturan(Request $request)
    {
        $user = User::find(auth()->user()->id);

        // Validasi input dengan pesan kustom bahasa Indonesia
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap tidak boleh kosong.',
            'email.required' => 'Alamat email tidak boleh kosong.',
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Hanya update password jika kolom password diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil dan keamanan akun Anda berhasil diperbarui!');
    }

    /**
     * 6. Menampilkan Halaman Form Cetak Laporan
     */
    public function indexLaporan()
    {
        $kategoriBantuan = KategoriBantuan::where('is_active', true)->get();
        return view('pimpinan.laporan.index', compact('kategoriBantuan'));
    }

    /**
     * 7. Proses Filter Data dan Generate PDF
     */
    public function cetakLaporan(Request $request)
    {
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

        $query = Pengajuan::with(['kategoriBantuan', 'user']);

        $query->whereBetween('created_at', [
            Carbon::parse($tanggalMulai)->startOfDay(), 
            Carbon::parse($tanggalAkhir)->endOfDay()
        ]);

        if ($status && $status != 'semua') {
            $query->where('status', $status);
        }

        if ($kategori_id && $kategori_id != 'semua') {
            $query->where('kategori_bantuan_id', $kategori_id);
        }

        $pengajuan = $query->orderBy('created_at', 'desc')->get();

        $data = [
            'pengajuan' => $pengajuan,
            'tanggalMulai' => Carbon::parse($tanggalMulai)->translatedFormat('d F Y'),
            'tanggalAkhir' => Carbon::parse($tanggalAkhir)->translatedFormat('d F Y'),
            'statusFilter' => $status == 'semua' ? 'Semua Status' : ucfirst($status),
        ];

        $pdf = Pdf::loadView('pimpinan.laporan.pdf', $data)->setPaper('a4', 'landscape');
        $namaFile = 'Laporan-Pengajuan-SIMPATIK-' . time() . '.pdf';
        
        return $pdf->stream($namaFile);
    }
}