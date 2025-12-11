@extends('layout_pengelola.app')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h3 class="mb-0 text-dark font-weight-bold">Data Mahasiswa</h3>
        </div>
        <div class="col-sm-6">
            {{-- Perbaikan float-right untuk AdminLTE 3 / Bootstrap 4 --}}
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('pengelola.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Mahasiswa</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    {{-- CARD FILTER DATA --}}
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filter Data</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('pengelola.mahasiswa.index') }}" method="GET">
                <div class="row align-items-end">
                    
                    {{-- Filter Angkatan --}}
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="angkatan" class="form-label font-weight-normal">Angkatan</label>
                        <select name="angkatan" id="angkatan" class="form-control">
                            <option value="">-- Semua Angkatan --</option>
                            @foreach ($angkatanList as $angkatan)
                                <option value="{{ $angkatan }}" {{ $selectedAngkatan == $angkatan ? 'selected' : '' }}>
                                    {{ $angkatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Kelas --}}
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="kelas" class="form-label font-weight-normal">Kelas</label>
                        <select name="kelas" id="kelas" class="form-control">
                            <option value="">-- Semua Kelas --</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ $selectedKelas == $kelas ? 'selected' : '' }}>
                                    Kelas {{ $kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Kelompok --}}
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label for="kelompok" class="form-label font-weight-normal">Kelompok</label>
                        <select name="kelompok" id="kelompok" class="form-control">
                            <option value="">-- Semua Kelompok --</option>
                            @foreach ($kelompokList as $kelompok)
                                <option value="{{ $kelompok }}" {{ $selectedKelompok == $kelompok ? 'selected' : '' }}>
                                    {{ $kelompok }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Filter --}}
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search mr-1"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- CARD TABEL DATA --}}
    <div class="card shadow-none border">
        <div class="card-header bg-light">
            <h3 class="card-title font-weight-bold">Hasil Pencarian</h3>
            <div class="card-tools">
                <span class="badge badge-info">{{ $mahasiswas->count() }} Data Ditemukan</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped text-nowrap">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%">No.</th>
                            <th style="width: 15%">NIM</th>
                            <th>Nama Lengkap</th>
                            <th class="text-center">Angkatan</th>
                            <th class="text-center">Kelas</th>
                            <th>Kelompok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswas as $mahasiswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="text-monospace">{{ $mahasiswa->kode_admin }}</span></td>
                                <td class="font-weight-bold">{{ $mahasiswa->name }}</td>
                                <td class="text-center">{{ $mahasiswa->angkatan ?? '-' }}</td>
                                <td class="text-center">
                                    @if($mahasiswa->kelas)
                                        <span class="font-weight-bold text-dark">{{ $mahasiswa->kelas }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($mahasiswa->kelompok)
                                        <span class="font-weight-bold text-dark">{{ $mahasiswa->kelompok }}</span>
                                    @else
                                        <span class="text-muted small">Belum ada</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-search fa-3x mb-3 text-gray-300"></i><br>
                                    Tidak ada data mahasiswa yang sesuai dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection