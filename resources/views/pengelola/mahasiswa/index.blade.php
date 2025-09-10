@extends('layout_pengelola.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Data Mahasiswa</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('pengelola.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Mahasiswa</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    {{-- FORM FILTER BARU --}}
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('pengelola.mahasiswa.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-10">
                        <label for="kelas" class="form-label">Pilih Kelas</label>
                        <select name="kelas" id="kelas" class="form-select">
                            <option value="">Tampilkan Semua Kelas</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ $selectedKelas == $kelas ? 'selected' : '' }}>
                                    Kelas {{ $kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <div class="card">
        <div class="card-header"><h3 class="card-title">Daftar Mahasiswa</h3></div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Nama Kelompok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswas as $mahasiswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mahasiswa->kode_admin }}</td>
                            <td>{{ $mahasiswa->name }}</td>
                            <td>{{ $mahasiswa->kelas }}</td>
                            <td>{{ $mahasiswa->kelompok }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data mahasiswa yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection