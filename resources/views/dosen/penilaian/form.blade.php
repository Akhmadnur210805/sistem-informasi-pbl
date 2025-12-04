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
                <li class="breadcrumb-item active" aria-current="page">{{ $matakuliah->nama_mk }} (Kelas {{ $kelas }})</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Penilaian untuk <strong>{{ $matakuliah->nama_mk }}</strong> - Kelas <strong>{{ $kelas }}</strong>
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('dosen.penilaian.store', ['matakuliah' => $matakuliah->id, 'kelas' => $kelas]) }}" method="POST">
                @csrf

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
                                        <th style="width: 20%">NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th style="width: 20%">Nilai Matkul (0-100)</th>
                                        <th style="width: 20%">Nilai Presentasi (0-100)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anggotas as $anggota)
                                        @php
                                            // Ambil data nilai jika sudah ada
                                            $nilai = $nilaiSudahAda->get($anggota->id);
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $anggota->kode_admin }}</td>
                                            <td>{{ $anggota->name }}</td>
                                            <td>
                                                {{-- Input Nilai Matkul --}}
                                                <input type="number" name="nilai_matkul[{{ $anggota->id }}]" class="form-control" 
                                                       value="{{ $nilai->nilai ?? '' }}" min="0" max="100" placeholder="0-100">
                                            </td>
                                            <td>
                                                {{-- Input Nilai Presentasi --}}
                                                <input type="number" name="nilai_presentasi[{{ $anggota->id }}]" class="form-control" 
                                                       value="{{ $nilai->nilai_presentasi ?? '' }}" min="0" max="100" placeholder="0-100">
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