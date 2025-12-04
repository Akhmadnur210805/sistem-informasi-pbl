@extends('layout_admin.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Dashboard Admin</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    {{-- BARIS 1: INFO BOXES --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box text-white bg-primary">
                <div class="inner">
                    <h3>{{ $jumlahMahasiswa }}</h3>
                    <p>Jumlah Mahasiswa</p>
                </div>
                <div class="icon"><i class="bi bi-people-fill"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-white bg-success">
                <div class="inner">
                    <h3>{{ $jumlahDosen }}</h3>
                    <p>Jumlah Dosen</p>
                </div>
                <div class="icon"><i class="bi bi-person-video3"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-white bg-warning">
                <div class="inner">
                    <h3>{{ $jumlahPengelola }}</h3>
                    <p>Jumlah Pengelola</p>
                </div>
                <div class="icon"><i class="bi bi-person-gear"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-white bg-danger">
                <div class="inner">
                    <h3>{{ $jumlahMataKuliah }}</h3>
                    <p>Mata Kuliah</p>
                </div>
                <div class="icon"><i class="bi bi-book-half"></i></div>
            </div>
        </div>
    </div>

    {{-- BARIS 2: TABEL RANKING --}}
    <div class="row">
        {{-- Ranking Mahasiswa --}}
        <div class="col-lg-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ranking Mahasiswa Terbaik (Top 5)</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nama Mahasiswa</th>
                                <th>Kelas</th>
                                <th class="text-center">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rankedMahasiswas as $mahasiswa)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $mahasiswa->name }}</td>
                                    <td>{{ $mahasiswa->kelas ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success fs-6">
                                            {{ number_format($mahasiswa->skor_akhir, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">Belum ada data mahasiswa.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Ranking Kelompok --}}
        <div class="col-lg-6">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Ranking Kelompok Terbaik (Top 5)</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Kelompok</th>
                                <th>Kelas</th>
                                <th class="text-center">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rankedKelompoks as $kelompok)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $kelompok->kelompok }}</td>
                                    <td>{{ $kelompok->kelas }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success fs-6">
                                            {{ number_format($kelompok->skor_akhir, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">Belum ada data kelompok.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
