<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Mustahik - {{ $pengajuan->nama_lengkap }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; margin: 0; padding: 0; }
        .header { text-align: center; border-bottom: 3px solid #1e5128; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #1e5128; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 12px; color: #666; }
        
        .container { padding: 20px; }
        
        .section-title { background-color: #f0fdf4; color: #1e5128; padding: 8px 12px; font-weight: bold; border-left: 5px solid #1e5128; margin: 20px 0 10px 0; text-transform: uppercase; font-size: 14px; }
        
        .profile-container { width: 100%; margin-bottom: 20px; }
        .photo-cell { width: 150px; vertical-align: top; }
        .photo-box { width: 120px; height: 160px; border: 1px solid #ddd; padding: 5px; }
        .photo-box img { width: 100%; height: 100%; object-fit: cover; }
        
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 8px 5px; vertical-align: top; font-size: 13px; }
        .label { width: 180px; font-weight: bold; color: #555; }
        .colon { width: 10px; }
        
        .footer-note { margin-top: 50px; font-size: 11px; text-align: right; color: #888; border-top: 1px solid #eee; padding-top: 10px; }
        .qr-placeholder { float: left; width: 80px; height: 80px; background: #eee; margin-top: 10px; }
        
        .badge { display: inline-block; padding: 3px 10px; border-radius: 50px; background: #1e5128; color: white; font-size: 11px; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>BADAN AMIL ZAKAT NASIONAL</h2>
        <p>Sistem Informasi Pengajuan Bantuan Zakat (SIMPATIK) - Tanah Laut</p>
    </div>

    <table class="profile-container">
        <tr>
            <td class="photo-cell">
                <div class="photo-box">
                    {{-- Pas Foto 3x4 hasil inovasi --}}
                    @if($pengajuan->pas_foto)
                        <img src="{{ public_path('storage/' . $pengajuan->pas_foto) }}">
                    @else
                        <div style="text-align:center; padding-top:60px; font-size:10px; color:#ccc;">TIDAK ADA FOTO</div>
                    @endif
                </div>
            </td>
            <td>
                <h3 style="margin: 0 0 5px 0; color: #1e5128;">{{ $pengajuan->nama_lengkap ?? $pengajuan->user->name }}</h3>
                <div class="badge">PROGRAM: {{ $pengajuan->kategoriBantuan->nama_bantuan }}</div>
                <p style="font-size: 12px; color: #666; margin-top: 10px;">
                    Nomor Registrasi: <strong>{{ $pengajuan->nomor_pengajuan }}</strong><br>
                    Tanggal Pengajuan: {{ $pengajuan->created_at->format('d F Y') }}
                </p>
            </td>
        </tr>
    </table>

    <div class="section-title">Identitas Pribadi (Sesuai KTP)</div>
    <table class="info-table">
        <tr>
            <td class="label">NIK</td>
            <td class="colon">:</td>
            <td>{{ $pengajuan->user->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td class="colon">:</td>
            <td>{{ $pengajuan->jenis_kelamin }}</td>
        </tr>
        <tr>
            <td class="label">Tempat, Tanggal Lahir</td>
            <td class="colon">:</td>
            <td>{{ $pengajuan->tempat_lahir }}, {{ \Carbon\Carbon::parse($pengajuan->tanggal_lahir)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Alamat Lengkap</td>
            <td class="colon">:</td>
            <td>{{ $pengajuan->alamat_ktp }}</td>
        </tr>
    </table>

    <div class="section-title">Profil Pendidikan & Ekonomi</div>
    <table class="info-table">
        <tr>
            <td class="label">Pendidikan Terakhir</td>
            <td class="colon">:</td>
            <td>{{ $pengajuan->pendidikan_terakhir }}</td>
        </tr>
        <tr>
            <td class="label">Pekerjaan Saat Ini</td>
            <td class="colon">:</td>
            <td>{{ $pengajuan->pekerjaan }}</td>
        </tr>
        <tr>
            <td class="label">Penghasilan Bulanan</td>
            <td class="colon">:</td>
            <td>Rp {{ number_format($pengajuan->penghasilan_bulanan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Jumlah Tanggungan</td>
            <td class="colon">:</td>
            <td>{{ $pengajuan->jumlah_tanggungan }} Orang</td>
        </tr>
        <tr>
            <td class="label">Link Koordinat Maps</td>
            <td class="colon">:</td>
            <td style="color: #0000EE; font-size: 11px;">{{ $pengajuan->titik_koordinat ?? 'Tidak dilampirkan' }}</td>
        </tr>
    </table>

    <div class="section-title">Deskripsi Kondisi & Kelayakan</div>
    <div style="font-size: 13px; text-align: justify; padding: 0 5px;">
        {{ $pengajuan->deskripsi_kondisi }}
    </div>

    <div class="footer-note">
        <div class="qr-placeholder" style="text-align: center; line-height: 80px; font-size: 9px; color: #999;">QR VALIDASI</div>
        <p>Dokumen ini dihasilkan secara otomatis oleh Sistem SIMPATIK BAZNAS.<br>
        Dicetak pada: {{ date('d/m/Y H:i') }} oleh Petugas Verifikasi.</p>
    </div>
</div>

</body>
</html>