@extends('layout_dosen.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Penilaian Proyek</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Penilaian</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pilih Mata Kuliah</h3>
        </div>
        <div class="card-body">
            <p>Silakan pilih mata kuliah yang akan dinilai kelompok bimbingannya.</p>
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th style="width: 120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mataKuliahs as $matakuliah)
                        <tr>
                            <td><strong>{{ $matakuliah->kode_mk }}</strong></td>
                            <td>{{ $matakuliah->nama_mk }}</td>
                            <td>{{ $matakuliah->sks }}</td>
                            <td>
                                {{-- Menghapus kelas 'btn-sm' agar ukuran tombol menjadi normal --}}
                                <a href="{{ route('dosen.penilaian.form', $matakuliah->id) }}" class="btn btn-primary w-100">
                                    <i class="bi bi-card-checklist me-1"></i> Beri Nilai
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                Belum ada data mata kuliah. Silakan hubungi Admin.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection