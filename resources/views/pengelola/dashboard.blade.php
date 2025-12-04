@extends('layout_pengelola.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Dashboard Pengelola</h3>
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
    <div class="row">
        {{-- Info Box Jumlah Mahasiswa --}}
        <div class="col-lg-4 col-6">
            <div class="small-box text-white bg-primary">
                <div class="inner">
                    <h3>{{ $jumlahMahasiswa }}</h3>
                    <p>Jumlah Mahasiswa</p>
                </div>
                <div class="icon"><i class="bi bi-person-fill"></i></div>
            </div>
        </div>

        {{-- Info Box Jumlah Dosen --}}
        <div class="col-lg-4 col-6">
            <div class="small-box text-white bg-success">
                <div class="inner">
                    <h3>{{ $jumlahDosen }}</h3>
                    <p>Jumlah Dosen</p>
                </div>
                <div class="icon"><i class="bi bi-person-badge-fill"></i></div>
            </div>
        </div>

        {{-- Info Box Jumlah Pengelola --}}
        <div class="col-lg-4 col-6">
            <div class="small-box text-white bg-warning">
                <div class="inner">
                    <h3>{{ $jumlahPengelola }}</h3>
                    <p>Jumlah Pengelola</p>
                </div>
                <div class="icon"><i class="bi bi-gear-wide-connected"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Ranking Mahasiswa --}}
        <div class="col-lg-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ranking Mahasiswa Terbaik (Top 5)</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th class="text-center">Nilai Akhir</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($rankedMahasiswas as $m)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $m->name }}</td>
                                <td>{{ $m->kelas }}</td>
                                <td class="text-center">
                                    <span class="badge bg-success fs-6">
                                        {{ number_format($m->skor_akhir, 2) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">Belum ada data penilaian</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Ranking Kelompok --}}
        <div class="col-lg-6">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Ranking Kelompok Terbaik (Top 5)</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Kelompok</th>
                            <th>Kelas</th>
                            <th class="text-center">Nilai Akhir</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($rankedKelompoks as $k)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $k->kelompok }}</td>
                                <td>{{ $k->kelas }}</td>
                                <td class="text-center">
                                    <span class="badge bg-success fs-6">
                                        {{ number_format($k->skor_akhir, 2) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">Belum ada data penilaian</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
