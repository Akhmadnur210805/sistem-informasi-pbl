@extends('layout_pengelola.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Rekap Nilai Mahasiswa</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('pengelola.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rekap Nilai</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('pengelola.rekap_nilai.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <label for="mata_kuliah_id" class="form-label">Mata Kuliah</label>
                        <select name="mata_kuliah_id" id="mata_kuliah_id" class="form-select">
                            <option value="">Semua Mata Kuliah</option>
                            @foreach ($mataKuliahs as $mk)
                                <option value="{{ $mk->id }}" {{ $selectedMataKuliahId == $mk->id ? 'selected' : '' }}>
                                    {{ $mk->nama_mk }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select name="kelas" id="kelas" class="form-select">
                            <option value="">Semua Kelas</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ $selectedKelas == $kelas ? 'selected' : '' }}>
                                    {{ $kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- DROPDOWN FILTER BARU UNTUK KELOMPOK --}}
                    <div class="col-md-3">
                        <label for="kelompok" class="form-label">Kelompok</label>
                        <select name="kelompok" id="kelompok" class="form-select">
                            <option value="">Semua Kelompok</option>
                            @foreach ($kelompokList as $kelompok)
                                <option value="{{ $kelompok }}" {{ $selectedKelompok == $kelompok ? 'selected' : '' }}>
                                    {{ $kelompok }}
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

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Hasil Rekap Nilai</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Kelas</th>
                        <th>Kelompok</th> {{-- <-- Kolom Baru --}}
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekapNilai as $nilai)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $nilai->nim }}</td>
                            <td>{{ $nilai->nama_mahasiswa }}</td>
                            <td>{{ $nilai->kelas }}</td>
                            <td>{{ $nilai->kelompok }}</td> {{-- <-- Data Baru --}}
                            <td>{{ $nilai->nilai ?? 'Belum Dinilai' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center"> {{-- Colspan jadi 6 --}}
                                Tidak ada data nilai yang ditemukan. Silakan sesuaikan filter Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection