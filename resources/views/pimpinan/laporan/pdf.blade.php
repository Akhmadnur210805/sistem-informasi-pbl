<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengajuan Bantuan SIMPATIK</title>
    <style>
        /* 1. MENGUNCI FORMAT KERTAS A4 LANDSCAPE DARI DALAM PDF */
        @page {
            size: A4 landscape;
            margin: 40px; /* Margin kertas keliling */
        }

        /* Pengaturan Dasar DOMPDF */
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 10px; 
            color: #333; 
            line-height: 1.4;
            position: relative; /* Penting untuk mengunci posisi Tanda Tangan */
        }
        
        /* 2. KOP SURAT (Penyesuaian Ukuran Logo) */
        .table-kop {
            width: 100%;
            border-bottom: 3px solid #1e5128;
            padding-bottom: 15px;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .table-kop td {
            border: none !important;
            padding: 0;
            vertical-align: middle;
        }

        /* Judul Laporan */
        .title-container { text-align: center; margin-bottom: 20px; }
        .title { font-weight: bold; font-size: 14px; text-transform: uppercase; text-decoration: underline; margin-bottom: 5px; }
        .subtitle { font-size: 11px; color: #555; }

        /* Desain Tabel Data Laporan */
        table.data-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 150px; /* Memberi jarak aman agar tabel tidak menabrak tanda tangan di bawah */
        }
        table.data-table th { 
            background-color: #1e5128; 
            color: #ffffff; 
            padding: 10px 8px; 
            text-align: left; 
            font-size: 10px; 
            text-transform: uppercase;
            border: 1px solid #1e5128;
        }
        table.data-table td { 
            border: 1px solid #cbd5e1; 
            padding: 8px; 
            vertical-align: top; 
        }
        table.data-table tr { page-break-inside: avoid; } 
        table.data-table tr:nth-child(even) { background-color: #f8fafc; }

        /* Utilitas Teks */
        .fw-bold { font-weight: bold; }
        .text-muted { color: #64748b; font-size: 9px; }
        .text-success { color: #15803d; }
        
        .badge { 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 9px; 
            font-weight: bold; 
            color: #fff; 
            display: inline-block;
            text-align: center;
        }
        .badge-success { background-color: #16a34a; }
        .badge-danger { background-color: #dc2626; }
        .badge-warning { background-color: #f59e0b; color: #fff; }

        /* 3. MENGUNCI TANDA TANGAN DI POJOK KANAN BAWAH KERTAS */
        .ttd-container { 
            position: absolute;
            bottom: 10px; /* Jarak dari bawah kertas */
            right: 20px;  /* Jarak dari kanan kertas */
            width: 250px; 
            text-align: center; 
        }
    </style>
</head>
<body>

    @php
        // TRIK MENGUBAH GAMBAR LOKAL KE BASE64
        $imagePath = public_path('images/BAZNASTALA.png');
        $logoBase64 = '';
        if(file_exists($imagePath)) {
            $logoData = file_get_contents($imagePath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }
    @endphp

    <table class="table-kop">
        <tr>
            <td style="width: 20%; text-align: left;">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo BAZNAS" style="width: 140px; height: auto;">
                @endif
            </td>
            
            <td style="width: 60%; text-align: center;">
                <h2 style="margin: 0; font-size: 22px; color: #1e5128; text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">BADAN AMIL ZAKAT NASIONAL (BAZNAS)</h2>
                <h3 style="margin: 0; font-size: 16px; font-weight: bold; color: #222; margin-top: 4px;">KABUPATEN TANAH LAUT</h3>
                <p style="margin: 6px 0 0 0; font-size: 11px; color: #555;">
                    Jl. Sapta Marga No 6, Pelaihari, Kabupaten Tanah Laut, Kalimantan Selatan, 70811.<br> 
                    Email: baznastanahlaut@gmail.com | Telp: +62 821-5208-4083
                </p>
            </td>
            
            <td style="width: 20%;"></td>
        </tr>
    </table>

    <div class="title-container">
        <div class="title">LAPORAN REKAPITULASI PENGAJUAN BANTUAN</div>
        <div class="subtitle">
            Periode: <strong>{{ $tanggalMulai }}</strong> s/d <strong>{{ $tanggalAkhir }}</strong> <br>
            Status Filter: <strong>{{ strtoupper($statusFilter) }}</strong>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">No</th>
                <th style="width: 16%;">Info Registrasi</th>
                <th style="width: 20%;">Identitas & Kontak</th>
                <th style="width: 20%;">Program & Nominal</th>
                <th style="width: 30%;">Alamat & Keterangan</th>
                <th style="width: 10%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuan as $index => $item)
                @php
                    $deskripsiMentah = $item->deskripsi_kondisi;
                    $nominal = '-';
                    $no_hp = '-';

                    if (preg_match('/Nominal Bantuan Diajukan:\s*Rp\s*([0-9.,]+)/i', $deskripsiMentah, $matches)) {
                        $nominal = 'Rp ' . $matches[1];
                        $deskripsiMentah = preg_replace('/Nominal Bantuan Diajukan:\s*Rp\s*[0-9.,]+/i', '', $deskripsiMentah);
                    }

                    if (preg_match('/No HP Kontak:\s*([0-9]+)/i', $deskripsiMentah, $matches)) {
                        $no_hp = $matches[1];
                        $deskripsiMentah = preg_replace('/No HP Kontak:\s*[0-9]+/i', '', $deskripsiMentah);
                    }

                    $keteranganBersih = trim(str_replace('Pengajuan Program PENDIDIKAN.', '', $deskripsiMentah));
                @endphp

            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>
                    <span class="fw-bold">{{ $item->nomor_pengajuan }}</span><br>
                    <span class="text-muted">Tgl: {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</span>
                </td>
                <td>
                    <span class="fw-bold">{{ $item->nama_lengkap }}</span><br>
                    <span class="text-muted">HP/WA: <span style="color: #333; font-weight:bold;">{{ $no_hp }}</span></span>
                </td>
                <td>
                    <span class="fw-bold">{{ $item->kategoriBantuan->nama_bantuan }}</span><br>
                    <span class="text-success fw-bold" style="font-size: 11px;">{{ $nominal }}</span>
                </td>
                <td>
                    <span class="fw-bold text-muted">Alamat:</span><br>
                    {{ $item->alamat_ktp }}
                    
                    @if($keteranganBersih != '')
                    <div style="margin-top: 5px; border-top: 1px dashed #cbd5e1; padding-top: 5px;">
                        <span class="fw-bold text-muted">Keterangan:</span><br>
                        {{ strip_tags($keteranganBersih) }}
                    </div>
                    @endif
                </td>
                <td style="text-align: center;">
                    @if($item->status == 'disetujui')
                        <span class="badge badge-success">DISETUJUI</span>
                    @elseif($item->status == 'ditolak')
                        <span class="badge badge-danger">DITOLAK</span>
                    @else
                        <span class="badge badge-warning">DIPROSES</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; font-style: italic; color: #777;">
                    Tidak ada data pengajuan yang ditemukan pada periode dan status yang dipilih.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-container">
        <p style="margin: 0;">Pelaihari, {{ date('d F Y') }}</p>
        <p style="margin: 5px 0 70px 0;">Pimpinan BAZNAS Kab. Tanah Laut,</p>
        <p style="margin: 0;"><strong style="text-decoration: underline;">( {{ Auth::user()->name ?? '____________________' }} )</strong></p>
    </div>

</body>
</html>