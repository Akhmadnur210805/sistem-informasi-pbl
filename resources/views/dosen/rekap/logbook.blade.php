@extends('layout_dosen.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Rekapitulasi Logbook Mahasiswa</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rekap Logbook</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
@forelse ($mahasiswaPerKelompok as $kelas => $kelompoks)
    <h4 class="mt-4 mb-3">Kelas: {{ $kelas }}</h4>
    @foreach ($kelompoks as $namaKelompok => $mahasiswas)
        <div class="card card-outline card-primary mb-4">
            <div class="card-header bg-light">
                <h3 class="card-title"><strong>{{ $namaKelompok }}</strong></h3>
            </div>
            <div class="card-body">
                @foreach ($mahasiswas as $mahasiswa)
                    <div class="mb-4 border-bottom pb-3">
                        <h5 class="text-primary">{{ $mahasiswa->name }} <small class="text-muted">({{ $mahasiswa->kode_admin }})</small></h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 10%;">Minggu Ke-</th>
                                        <th>Deskripsi</th>
                                        <th style="width: 10%;">File</th>
                                        <th style="width: 20%;">Tanggal Upload</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($mahasiswa->logbooks as $logbook)
                                    <tr>
                                        <td class="text-center">{{ $logbook->minggu_ke }}</td>
                                        <td>{{ $logbook->deskripsi }}</td>
                                        <td class="text-center">
                                            @if ($logbook->file_path)
                                                <a href="{{ asset('storage/' . $logbook->file_path) }}" target="_blank" class="btn btn-xs btn-info">Download</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        {{-- PERBAIKAN JAM DI SINI: Menambahkan setTimezone --}}
                                        <td>{{ $logbook->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center text-muted">Belum ada logbook.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@empty
    <div class="alert alert-warning text-center">Tidak ada data mahasiswa untuk ditampilkan.</div>
@endforelse
@endsection