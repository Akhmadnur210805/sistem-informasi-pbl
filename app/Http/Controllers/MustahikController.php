<?php

namespace App\Http\Controllers;

use App\Models\KategoriBantuan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MustahikController extends Controller
{
    public function dashboard(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $daftarBantuan = KategoriBantuan::where('is_active', true)->get();
        return view('mustahik.dashboard', compact('user', 'daftarBantuan'));
    }

    public function createPengajuan($id): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $kategori = KategoriBantuan::findOrFail($id);

        switch ($kategori->jenis_form) {
            case 'pendidikan': return view('mustahik.pengajuan.form_pendidikan', compact('user', 'kategori'));
            case 'dakwah': return view('mustahik.pengajuan.form_dakwah', compact('user', 'kategori'));
            case 'ekonomi': return view('mustahik.pengajuan.form_ekonomi', compact('user', 'kategori'));
            case 'kesehatan': return view('mustahik.pengajuan.form_kesehatan', compact('user', 'kategori'));
            case 'kemanusiaan': return view('mustahik.pengajuan.form_kemanusiaan', compact('user', 'kategori'));
            default: return view('mustahik.pengajuan.form_umum', compact('user', 'kategori'));
        }
    }

    public function storePengajuan(Request $request): RedirectResponse
    {
        $kategoriId = $request->input('kategori_bantuan_id');
        $kategori = KategoriBantuan::findOrFail($kategoriId);
        $jenisForm = $kategori->jenis_form;

        // ==========================================
        // 1. VALIDASI DINAMIS BERDASARKAN JENIS FORM
        // ==========================================
        if ($jenisForm === 'dakwah') { 
            $rules = [
                'kategori_bantuan_id' => 'required|exists:kategori_bantuans,id',
                'nama_lengkap'        => 'required|string|max:255',
                'no_hp'               => 'required|string|max:20',
                'alamat_ktp'          => 'required|string',
                'file_ktp'            => 'required|mimes:pdf,jpg,jpeg,png|max:10240', 
                'file_pendukung'      => 'required|mimes:pdf,doc,docx|max:10240', 
            ];
        } elseif ($jenisForm === 'kemanusiaan') { 
            $rules = [
                'kategori_bantuan_id' => 'required|exists:kategori_bantuans,id',
                'nama_lengkap'        => 'required|string|max:255',
                'no_hp'               => 'required|string|max:20',
                'alamat_ktp'          => 'required|string',
                'pas_foto'            => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'file_ktp'            => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_kk'             => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_sktm'           => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_pendukung'      => 'required|mimes:pdf|max:10240', 
            ];
        } elseif ($jenisForm === 'ekonomi') { 
            $rules = [
                'kategori_bantuan_id' => 'required|exists:kategori_bantuans,id',
                'nama_lengkap'        => 'required|string|max:255',
                'no_hp'               => 'required|string|max:20',
                'alamat_ktp'          => 'required|string',
                'nominal_pengajuan'   => 'required|string', 
                'pas_foto'            => 'required|image|mimes:jpg,jpeg,png|max:2048', 
                'file_ktp'            => 'required|mimes:pdf,jpg,jpeg,png|max:2048',   
                'file_kk'             => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_sktm'           => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_pendukung'      => 'required|mimes:pdf|max:10240', 
            ];
        } elseif ($jenisForm === 'kesehatan') { 
            $rules = [
                'kategori_bantuan_id' => 'required|exists:kategori_bantuans,id',
                'nama_lengkap'        => 'required|string|max:255',
                'no_hp'               => 'required|string|max:20',
                'alamat_ktp'          => 'required|string',
                'nominal_pengajuan'   => 'required|string', 
                'pas_foto'            => 'required|image|mimes:jpg,jpeg,png|max:2048', 
                'file_ktp'            => 'required|mimes:pdf,jpg,jpeg,png|max:2048',   
                'file_kk'             => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_sktm'           => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_pendukung'      => 'required|mimes:pdf|max:10240', 
            ];
        } elseif ($jenisForm === 'pendidikan') { 
            $rules = [
                'kategori_bantuan_id' => 'required|exists:kategori_bantuans,id',
                'nama_lengkap'        => 'required|string|max:255',
                'no_hp'               => 'required|string|max:20',
                'alamat_ktp'          => 'required|string',
                'nominal_pengajuan'   => 'required|string', 
                'pas_foto'            => 'required|image|mimes:jpg,jpeg,png|max:2048', 
                'file_ktp'            => 'required|mimes:pdf,jpg,jpeg,png|max:2048',   
                'file_kk'             => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_sktm'           => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_pendukung'      => 'required|mimes:pdf|max:10240', 
            ];
        } else {
            $rules = [
                'kategori_bantuan_id' => 'required|exists:kategori_bantuans,id',
                'nama_lengkap'        => 'required|string|max:255',
                'jenis_kelamin'       => 'required|in:Laki-laki,Perempuan',
                'tempat_lahir'        => 'required|string',
                'tanggal_lahir'       => 'required|date',
                'alamat_ktp'          => 'required|string',
                'jumlah_tanggungan'   => 'required|numeric',
                'penghasilan_bulanan' => 'required',
                'deskripsi_kondisi'   => 'required|string',
                'pekerjaan'           => 'required|string',
                'pas_foto'            => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'file_ktp'            => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_kk'             => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_sktm'           => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
                'file_pendukung'      => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            ];
        }

        $request->validate($rules);

        // ==========================================
        // 2. PROSES PENYIMPANAN DATA
        // ==========================================
        $user = Auth::user();
        
        if (in_array($jenisForm, ['dakwah', 'kemanusiaan', 'ekonomi', 'kesehatan', 'pendidikan']) && $request->filled('no_hp')) {
            /** @var \App\Models\User $userModel */
            $userModel = $user;
            $userModel->no_hp = $request->input('no_hp');
            $userModel->save();
        }

        $nomor_pengajuan = 'REQ-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        $penghasilan = str_replace('.', '', $request->input('penghasilan_bulanan', '0'));

        $pasFotoPath   = $request->hasFile('pas_foto') ? $request->file('pas_foto')->store('pengajuan/pas_foto', 'public') : null;
        $ktpPath       = $request->file('file_ktp')->store('pengajuan/ktp', 'public');
        $kkPath        = $request->hasFile('file_kk') ? $request->file('file_kk')->store('pengajuan/kk', 'public') : null;
        $sktmPath      = $request->hasFile('file_sktm') ? $request->file('file_sktm')->store('pengajuan/sktm', 'public') : null;
        $pendukungPath = $request->hasFile('file_pendukung') ? $request->file('file_pendukung')->store('pengajuan/pendukung', 'public') : null;

        $jenisKelamin     = $request->input('jenis_kelamin', '-');
        $tempatLahir      = $request->input('tempat_lahir', '-');
        $tanggalLahir     = $request->input('tanggal_lahir', now()->format('Y-m-d'));
        $pekerjaan        = $request->input('pekerjaan', '-');
        $jumlahTanggungan = $request->input('jumlah_tanggungan', 0);
        
        if (in_array($jenisForm, ['ekonomi', 'kesehatan', 'pendidikan'])) {
            $label = strtoupper($jenisForm); 
            $deskripsi = "Pengajuan Program " . $label . ". \nNominal Bantuan Diajukan: Rp " . $request->input('nominal_pengajuan') . "\nNo HP Kontak: " . $request->input('no_hp');
        } elseif (in_array($jenisForm, ['dakwah', 'kemanusiaan'])) {
            $deskripsi = "Pengajuan Program " . strtoupper($jenisForm) . ". \nNo HP Kontak: " . $request->input('no_hp');
        } else {
            $deskripsi = $request->input('deskripsi_kondisi');
        }

        Pengajuan::create([
            'user_id'             => $user->id,
            'kategori_bantuan_id' => $kategoriId,
            'nomor_pengajuan'     => $nomor_pengajuan,
            'nama_lengkap'        => $request->input('nama_lengkap'),
            'jenis_kelamin'       => $jenisKelamin,
            'tempat_lahir'        => $tempatLahir,
            'tanggal_lahir'       => $tanggalLahir,
            'alamat_ktp'          => $request->input('alamat_ktp'),
            'penghasilan_bulanan' => $penghasilan,
            'jumlah_tanggungan'   => $jumlahTanggungan,
            'pendidikan_terakhir' => $request->input('pendidikan_terakhir', '-'),
            'pekerjaan'           => $pekerjaan,
            'titik_koordinat'     => $request->input('titik_koordinat', null),
            'deskripsi_kondisi'   => $deskripsi,
            'pas_foto'            => $pasFotoPath,
            'file_ktp'            => $ktpPath,
            'file_kk'             => $kkPath,
            'file_pendukung'      => $pendukungPath,
            'file_sktm'           => $sktmPath,
            'status'              => 'menunggu',
        ]);

        return redirect()->route('mustahik.riwayat')
            ->with('success', 'Pengajuan berhasil dikirim! Nomor Resi: ' . $nomor_pengajuan);
    }

    public function riwayat(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $riwayat = Pengajuan::where('user_id', $user->id)
                            ->with('kategoriBantuan')
                            ->latest()
                            ->get();
        return view('mustahik.riwayat.index', compact('user', 'riwayat'));
    }

    public function showDetail($id): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $pengajuan = Pengajuan::where('user_id', $user->id)
                              ->with('kategoriBantuan')
                              ->findOrFail($id);

        return view('mustahik.riwayat.detail', compact('user', 'pengajuan'));
    }

    // ==========================================
    // FUNGSI BARU: PROFIL PENGGUNA
    // ==========================================
    public function profil(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        return view('mustahik.profil', compact('user'));
    }
}