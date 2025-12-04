<!DOCTYPE html>
<html>
<head>
    <title>Rekap Nilai PBL - {{ $kelas }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-start { text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Rekapitulasi Nilai PBL</h2>
        <p>Kelas: {{ $kelas }} | Tanggal Cetak: {{ date('d-m-Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">NIM</th>
                <th class="text-start">Nama Mahasiswa</th>
                <th style="width: 10%">Kelas</th>
                <th style="width: 15%">Kelompok</th>
                <th style="width: 15%">Skor Individu</th>
                <th style="width: 15%">Skor Kelompok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswas as $mhs)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mhs->kode_admin }}</td>
                    <td class="text-start">{{ $mhs->name }}</td>
                    <td>{{ $mhs->kelas }}</td>
                    <td>{{ $mhs->kelompok ?? '-' }}</td>
                    <td>{{ $mhs->nilai_akhir_individu }}</td>
                    <td>{{ $mhs->nilai_akhir_kelompok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>