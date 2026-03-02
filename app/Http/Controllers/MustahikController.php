<?php

namespace App\Http\Controllers;

use App\Models\KategoriBantuan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MustahikController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();
        $daftarBantuan = KategoriBantuan::where('is_active', true)->get();
        return view('mustahik.dashboard', compact('user', 'daftarBantuan'));
    }

    public function createPengajuan($id): View
    {
        $user = Auth::user();
        $kategori = KategoriBantuan::findOrFail($id);
        return view('mustahik.pengajuan.index', compact('user', 'kategori'));
    }

    /**
     * Simpan Data Pengajuan
     */
    public function storePengajuan(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'kategori_bantuan_id' => 'required',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat_ktp' => 'required|string',
            'jumlah_tanggungan' => 'required|numeric',
            'penghasilan_bulanan' => 'required',
            'deskripsi_kondisi' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'pekerjaan' => 'required|string',
            'pas_foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'file_ktp' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_pendukung' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_sktm' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'titik_koordinat' => 'nullable|string',
        ]);

        // 2. Bersihkan format Rupiah
        $penghasilan = str_replace('.', '', $request->penghasilan_bulanan);

        // 3. Generate Nomor Pengajuan Unik
        $nomor_pengajuan = 'REQ-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        // 4. Proses Upload File
        $pasFotoPath = $request->file('pas_foto')->store('pengajuan/pas_foto', 'public');
        $ktpPath = $request->file('file_ktp')->store('pengajuan/ktp', 'public');
        $kkPath = $request->file('file_kk')->store('pengajuan/kk', 'public');
        $rumahPath = $request->file('file_pendukung')->store('pengajuan/rumah', 'public');
        
        $sktmPath = $request->hasFile('file_sktm') 
            ? $request->file('file_sktm')->store('pengajuan/sktm', 'public') 
            : null;

        // 5. Simpan ke Database
        Pengajuan::create([
            'user_id' => Auth::id(),
            'kategori_bantuan_id' => $request->kategori_bantuan_id,
            'nomor_pengajuan' => $nomor_pengajuan,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat_ktp' => $request->alamat_ktp,
            'penghasilan_bulanan' => $penghasilan,
            'jumlah_tanggungan' => $request->jumlah_tanggungan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'pekerjaan' => $request->pekerjaan,
            'titik_koordinat' => $request->titik_koordinat,
            'deskripsi_kondisi' => $request->deskripsi_kondisi,
            'pas_foto' => $pasFotoPath,
            'file_ktp' => $ktpPath,
            'file_kk' => $kkPath,
            'file_pendukung' => $rumahPath,
            'file_sktm' => $sktmPath,
            'status' => 'menunggu',
        ]);

        return redirect()->route('mustahik.riwayat')
            ->with('success', 'Pengajuan berhasil dikirim! Nomor: ' . $nomor_pengajuan);
    }

    public function riwayat(): View
    {
        $user = Auth::user();
        $riwayat = Pengajuan::where('user_id', $user->id)
                            ->with('kategoriBantuan')
                            ->latest()
                            ->get();
        return view('mustahik.riwayat.index', compact('user', 'riwayat'));
    }

    public function showDetail($id): View
    {
        $user = Auth::user();
        $pengajuan = Pengajuan::where('user_id', $user->id)
                              ->with('kategoriBantuan')
                              ->findOrFail($id);

        return view('mustahik.riwayat.detail', compact('user', 'pengajuan'));
    }

    /**
     * FITUR BARU: Menampilkan halaman Tentang BAZNAS
     */
    public function about(): View
    {
        $user = Auth::user();
        return view('mustahik.about', compact('user'));
    }
}