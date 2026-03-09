<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Mustahik - {{ $pengajuan->nama_lengkap }}</title>
    <style>
        @page { margin: 1cm; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        /* Kop Surat */
        .kop-surat {
            border-bottom: 3px solid #1e5128;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .kop-surat h2 { margin: 0; font-size: 18px; color: #1e5128; }
        .kop-surat h3 { margin: 0; font-size: 14px; }
        .kop-surat p { margin: 0; font-size: 10px; font-style: italic; }

        .title {
            text-align: center;
            text-transform: uppercase;
            text-decoration: underline;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
        }

        /* Informasi Utama */
        .info-utama {
            width: 100%;
            margin-bottom: 20px;
        }
        .foto-container {
            width: 120px;
            height: 150px;
            border: 2px dashed #ccc;
            text-align: center;
            background-color: #f9f9f9;
            overflow: hidden;
        }
        .foto-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .no-foto {
            font-size: 10px;
            color: #999;
            padding-top: 60px;
            font-weight: bold;
        }

        /* Tabel Data */
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .section-title {
            background-color: #e8f5e9;
            color: #1e5128;
            font-weight: bold;
            padding: 6px 10px;
            border-left: 5px solid #1e5128;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        td { padding: 6px; vertical-align: top; border-bottom: 1px solid #f0f0f0; }
        .label { width: 35%; color: #555; }
        .value { width: 65%; font-weight: bold; color: #000; }

        /* Deskripsi Box */
        .box {
            border: 1px solid #d4edda;
            padding: 12px;
            background-color: #f8fff9;
            min-height: 60px;
            border-radius: 5px;
            font-size: 12px;
            line-height: 1.6;
        }

        /* Footer & QR */
        .footer {
            margin-top: 40px;
            width: 100%;
        }
        .qr-code {
            float: left;
            width: 120px;
            text-align: center;
        }
        .qr-code img {
            width: 90px;
            height: 90px;
            border: 1px solid #ccc;
            padding: 3px;
            background: #fff;
        }
        .ttd {
            float: right;
            width: 250px;
            text-align: center;
        }
        .clear { clear: both; }
        
        .watermark {
            position: absolute;
            bottom: -15px;
            right: 0;
            font-size: 9px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>BADAN AMIL ZAKAT NASIONAL (BAZNAS)</h2>
        <h3>KABUPATEN TANAH LAUT</h3>
        <p>Jl. Jend. Sudirman No. 1, Pelaihari, Kalimantan Selatan 70815. Email: info@baznastala.org</p>
    </div>

    <div class="title">PROFIL RINGKAS PERMOHONAN BANTUAN</div>

    <table class="info-utama">
        <tr>
            <td style="width: 140px; border: none;">
                <div class="foto-container">
                    @if($pengajuan->pas_foto)
                        <img src="{{ public_path('storage/' . $pengajuan->pas_foto) }}" alt="Foto">
                    @else
                        <div class="no-foto">BERBASIS<br>PROPOSAL</div>
                    @endif
                </div>
            </td>
            <td style="border: none;">
                <table style="margin-top: -5px; border: none;">
                    <tr>
                        <td class="label" style="border: none;">Nama Lengkap</td>
                        <td class="value" style="border: none;">: {{ strtoupper($pengajuan->nama_lengkap) }}</td>
                    </tr>
                    <tr>
                        <td class="label" style="border: none;">Program Bantuan</td>
                        <td class="value" style="border: none;">: {{ $pengajuan->kategoriBantuan->nama_bantuan }}</td>
                    </tr>
                    <tr>
                        <td class="label" style="border: none;">No. Registrasi</td>
                        <td class="value" style="border: none;">: {{ $pengajuan->nomor_pengajuan }}</td>
                    </tr>
                    <tr>
                        <td class="label" style="border: none;">Status Verifikasi</td>
                        <td class="value" style="border: none;">: 
                            @if($pengajuan->status == 'disetujui')
                                <span style="color: green;">DISETUJUI</span>
                            @elseif($pengajuan->status == 'ditolak')
                                <span style="color: red;">DITOLAK</span>
                            @else
                                <span style="color: orange;">MENUNGGU</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="border: none;">Tgl Pengajuan</td>
                        <td class="value" style="border: none;">: {{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d F Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="section-title">IDENTITAS PRIBADI & DOMISILI</div>
    <table>
        @if($pengajuan->jenis_kelamin && $pengajuan->jenis_kelamin != '-')
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td class="value">: {{ $pengajuan->jenis_kelamin }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Alamat Lokasi / KTP</td>
            <td class="value">: {{ $pengajuan->alamat_ktp }}</td>
        </tr>
        @if($pengajuan->titik_koordinat)
        <tr>
            <td class="label">Koordinat Google Maps</td>
            <td class="value">: {{ $pengajuan->titik_koordinat }}</td>
        </tr>
        @endif
    </table>

    @php
        // CEK APAKAH ADA DATA EKONOMI YANG DIINPUT
        // Jika ketiganya kosong / default, maka jangan tampilkan section ini sama sekali
        $adaDataEkonomi = ($pengajuan->pendidikan_terakhir != '-' || $pengajuan->pekerjaan != '-' || $pengajuan->penghasilan_bulanan > 0);
    @endphp

    @if($adaDataEkonomi)
    <div class="section-title">PROFIL PENDIDIKAN & EKONOMI</div>
    <table>
        @if($pengajuan->pendidikan_terakhir && $pengajuan->pendidikan_terakhir != '-')
        <tr>
            <td class="label">Pendidikan Terakhir</td>
            <td class="value">: {{ $pengajuan->pendidikan_terakhir }}</td>
        </tr>
        @endif
        @if($pengajuan->pekerjaan && $pengajuan->pekerjaan != '-')
        <tr>
            <td class="label">Pekerjaan Saat Ini</td>
            <td class="value">: {{ $pengajuan->pekerjaan }}</td>
        </tr>
        @endif
        @if($pengajuan->penghasilan_bulanan > 0)
        <tr>
            <td class="label">Penghasilan Bulanan</td>
            <td class="value">: Rp {{ number_format($pengajuan->penghasilan_bulanan, 0, ',', '.') }}</td>
        </tr>
        @endif
    </table>
    @endif

    <div class="section-title">RINCIAN & KETERANGAN PENGAJUAN</div>
    <div class="box">
        {!! nl2br(e($pengajuan->deskripsi_kondisi)) !!}
    </div>

    <div class="footer">
        <div class="qr-code">
            {{-- Menggunakan API QR Code Server --}}
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $pengajuan->nomor_pengajuan }}" alt="QR Validasi">
            <p style="font-size: 9px; margin-top: 5px; font-weight: bold;">SCAN UNTUK VALIDASI</p>
        </div>
        <div class="ttd">
            <p>Pelaihari, {{ date('d F Y') }}</p>
            <p style="margin-bottom: 70px;">Petugas Verifikator BAZNAS,</p>
            <p><strong>( ________________________ )</strong></p>
            <p style="font-size: 10px;">ID: {{ Auth::user()->name }}</p>
        </div>
    </div>

    <div class="clear"></div>

    <div class="watermark">
        Dokumen dicetak melalui Sistem SIMPATIK BAZNAS Tanah Laut pada {{ date('d/m/Y H:i') }}
    </div>

</body>
</html>