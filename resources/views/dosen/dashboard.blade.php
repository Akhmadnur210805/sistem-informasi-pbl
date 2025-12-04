@extends('layout_dosen.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Dashboard Dosen</h3>
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

        {{-- Info Box Jumlah Kelompok --}}
        <div class="col-lg-4 col-6">
            <div class="small-box text-white bg-danger">
                <div class="inner">
                    <h3>{{ $jumlahKelompok }}</h3>
                    <p>Jumlah Kelompok</p>
                </div>
                <div class="icon"><i class="bi bi-people-fill"></i></div>
            </div>
        </div>

        {{-- Info Box Jumlah Mata Kuliah --}}
        <div class="col-lg-4 col-6">
            <div class="small-box text-white bg-warning">
                <div class="inner">
                    <h3>{{ $jumlahMataKuliah }}</h3>
                    <p>Jumlah Mata Kuliah</p>
                </div>
                <div class="icon"><i class="bi bi-book"></i></div>
            </div>
        </div>
    </div>
    
    <div class="row">
        {{-- Card Ranking Mahasiswa --}}
        <div class="col-lg-6">
            <div class="card card-outline card-primary">
                <div class="card-header"><h3 class="card-title">Ranking Mahasiswa Terbaik (Top 5)</h3></div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover">
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
                                <tr><td colspan="4" class="text-center">Belum ada data penilaian.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Card Ranking Kelompok --}}
        <div class="col-lg-6">
            <div class="card card-outline card-danger">
                <div class="card-header"><h3 class="card-title">Ranking Kelompok Terbaik (Top 5)</h3></div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover">
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
                                    <td>{{ $kelompok->kelompok ?? '-' }}</td>
                                    <td>{{ $kelompok->kelas ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success fs-6">
                                            {{ number_format($kelompok->skor_akhir, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">Belum ada data penilaian.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
