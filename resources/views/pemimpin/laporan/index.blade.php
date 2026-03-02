@extends('layout_pengelola.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Rekap Nilai Akhir (SAW)</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rekap Nilai</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Filter & Export Data</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('pengelola.rekap_nilai.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    
                    {{-- FILTER ANGKATAN --}}
                    <div class="col-md-3">
                        <label class="form-label">Pilih Angkatan</label>
                        <select name="angkatan" class="form-select">
                            <option value="Semua Angkatan">Semua Angkatan</option>
                            @foreach ($angkatanList as $thn)
                                <option value="{{ $thn }}" {{ $selectedAngkatan == $thn ? 'selected' : '' }}>
                                    {{ $thn }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- FILTER KELAS --}}
                    <div class="col-md-3">
                        <label class="form-label">Pilih Kelas</label>
                        <select name="kelas" class="form-select">
                            <option value="Semua Kelas">Semua Kelas</option>
                            @foreach ($kelasList as $k)
                                <option value="{{ $k }}" {{ $selectedKelas == $k ? 'selected' : '' }}>
                                    Kelas {{ $k }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TOMBOL FILTER --}}
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                    </div>

                    {{-- TOMBOL DOWNLOAD PDF --}}
                    <div class="col-md-3 ms-auto">
                        <a href="{{ route('pengelola.rekap_nilai.download', ['kelas' => $selectedKelas, 'angkatan' => $selectedAngkatan]) }}" target="_blank" class="btn btn-danger w-100">
                            <i class="bi bi-file-earmark-pdf-fill"></i> Download PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover table-striped table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 15%">NIM</th>
                        <th class="text-start">Nama Mahasiswa</th>
                        <th style="width: 10%">Angkatan</th>
                        <th style="width: 10%">Kelas</th>
                        <th style="width: 15%">Kelompok</th>
                        <th style="width: 15%">Skor Individu</th>
                        <th style="width: 15%">Skor Kelompok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswas as $mhs)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mhs->kode_admin }}</td>
                            <td class="text-start">{{ $mhs->name }}</td>
                            <td>{{ $mhs->angkatan ?? '-' }}</td>
                            <td>{{ $mhs->kelas }}</td>
                            <td>{{ $mhs->kelompok ?? '-' }}</td>
                            <td>
                                <span class="badge bg-primary fs-6">{{ $mhs->nilai_akhir_individu }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success fs-6">{{ $mhs->nilai_akhir_kelompok }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                Data tidak ditemukan untuk filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection