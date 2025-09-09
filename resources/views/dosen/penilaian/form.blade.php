@extends('layout_dosen.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Formulir Penilaian</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dosen.penilaian.index') }}">Penilaian</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $matakuliah->nama_mk }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Penilaian untuk Mata Kuliah: <strong>{{ $matakuliah->nama_mk }} ({{ $matakuliah->sks }} SKS)</strong>
            </h3>
        </div>
        <div class="card-body">
            {{-- PERBARUI ACTION FORM DI SINI --}}
            <form action="{{ route('dosen.penilaian.store', $matakuliah->id) }}" method="POST">
                @csrf
                @forelse ($kelompoks as $kelas => $kelompokPerKelas)
                    <h4 class="mb-3 mt-4 text-center bg-light p-2 rounded"><b>Kelas {{ $kelas }}</b></h4>
                    @foreach ($kelompokPerKelas as $namaKelompok => $anggotas)
                        <div class="card card-outline card-primary mb-4">
                            <div class="card-header">
                                <h5 class="card-title">{{ $namaKelompok }}</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th style="width: 5%">No.</th>
                                            <th style="width: 25%">NIM</th>
                                            <th>Nama Mahasiswa</th>
                                            <th style="width: 15%">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($anggotas as $anggota)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $anggota->kode_admin }}</td>
                                                <td>{{ $anggota->name }}</td>
                                                <td>
                                                    <input type="number" name="nilai[{{ $anggota->id }}]" class="form-control" min="0" max="100" placeholder="0-100">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @empty
                    <div class="alert alert-warning text-center">
                        Tidak ada kelompok mahasiswa yang bisa dinilai.
                    </div>
                @endforelse

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Simpan Nilai</button>
                    <a href="{{ route('dosen.penilaian.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection