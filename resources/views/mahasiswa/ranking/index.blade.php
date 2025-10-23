@extends('layout_mahasiswa.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Peringkat Keseluruhan</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('mahasiswa.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ranking</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Ranking Mahasiswa Terbaik</h3></div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Mahasiswa</th>
                                <th>Kelas</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mahasiswas as $mahasiswa)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $mahasiswa->name }}</td>
                                    <td>{{ $mahasiswa->kelas }}</td>
                                    <td><span class="badge text-bg-success">{{ number_format($mahasiswa->rata_rata_nilai, 0) }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Ranking Kelompok Terbaik</h3></div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kelompok</th>
                                <th>Kelas</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                             @forelse ($kelompoks as $kelompok)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $kelompok->kelompok }}</td>
                                    <td>{{ $kelompok->kelas }}</td>
                                    <td><span class="badge text-bg-info">{{ number_format($kelompok->rata_rata_nilai, 0) }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection