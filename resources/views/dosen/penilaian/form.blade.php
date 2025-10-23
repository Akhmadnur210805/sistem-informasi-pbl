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
                {{-- Menambahkan info kelas di breadcrumb --}}
                <li class="breadcrumb-item active" aria-current="page">{{ $matakuliah->nama_mk }} (Kelas {{ $kelas }})</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{-- Menampilkan info kelas di judul --}}
                Penilaian untuk <strong>{{ $matakuliah->nama_mk }}</strong> - Kelas <strong>{{ $kelas }}</strong>
            </h3>
        </div>
        <div class="card-body">
            {{-- ACTION FORM DIPERBAIKI UNTUK MENGIRIM PARAMETER 'kelas' --}}
            <form action="{{ route('dosen.penilaian.store', ['matakuliah' => $matakuliah->id, 'kelas' => $kelas]) }}" method="POST">
                @csrf

                {{-- LOOPING DIPERBAIKI: Langsung ke kelompok, tidak perlu grouping kelas lagi --}}
                @forelse ($kelompoks as $namaKelompok => $anggotas)
                    <div class="card card-outline card-primary mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Kelompok {{ $namaKelompok }}</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
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
                @empty
                    <div class="alert alert-warning text-center">
                        Tidak ada kelompok mahasiswa yang bisa dinilai di kelas ini.
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