@extends('layout_admin.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Dashboard</h3>
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
        <div class="col-lg-3 col-6">
            <div class="small-box text-white bg-primary">
                <div class="inner">
                    <h3>{{ $jumlahMahasiswa }}</h3>
                    <p>Jumlah Mahasiswa</p>
                </div>
                <div class="icon">
                    <i class="bi bi-person-bounding-box"></i>
                </div>
            </div>
        </div>

        {{-- Info Box Jumlah Dosen --}}
    <div class="col-lg-3 col-6">
    <div class="small-box text-white bg-success">
        <div class="inner">
            {{-- INI BAGIAN YANG DIPERBARUI --}}
            <h3>{{ $jumlahDosen }}</h3>
            <p>Jumlah Dosen</p>
        </div>
        <div class="icon">
            <i class="bi bi-person-vcard"></i>
        </div>
    </div>
    </div>

        {{-- KOTAK BARU: Info Box Jumlah Pengelola --}}
        <div class="col-lg-3 col-6">
            <div class="small-box text-white bg-info">
                <div class="inner">
                    <h3>{{ $jumlahPengelola }}</h3>
                    <p>Jumlah Pengelola</p>
                </div>
                <div class="icon">
                    <i class="bi bi-person-gear"></i>
                </div>
            </div>
        </div>

        {{-- Info Box Jumlah Kelompok --}}
        <div class="col-lg-3 col-6">
            <div class="small-box text-white bg-danger">
                <div class="inner">
                    <h3>8</h3>
                    <p>Jumlah Kelompok</p>
                </div>
                <div class="icon">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Card Ranking Kelompok --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ranking Kelompok Terbaik</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Kelompok</th>
                                <th>Kelas</th> {{-- <-- KOLOM BARU --}}
                                <th style="width: 40px">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data ini masih statis, nanti akan dibuat dinamis --}}
                            <tr>
                                <td>1.</td>
                                <td>Kelompok 1</td>
                                <td>A</td> {{-- <-- KOLOM BARU --}}
                                <td><span class="badge text-bg-success">85</span></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Kelompok 2</td>
                                <td>B</td> {{-- <-- KOLOM BARU --}}
                                <td><span class="badge text-bg-info">83</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Card Ranking Mahasiswa Terbaik --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ranking Mahasiswa Terbaik</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nama Mahasiswa</th>
                                <th>Kelas</th> {{-- <-- KOLOM BARU --}}
                                <th style="width: 40px">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rankedMahasiswas as $mahasiswa)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $mahasiswa->name }}</td>
                                    <td>{{ $mahasiswa->kelas }}</td> {{-- <-- KOLOM BARU --}}
                                    <td><span class="badge text-bg-success">{{ rand(85, 95) }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    {{-- Colspan diubah menjadi 4 --}}
                                    <td colspan="4" class="text-center">Belum ada data mahasiswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection