@extends('layout_admin.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Data Kelompok</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Kelompok</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    @forelse ($kelompoks as $kelas => $kelompokPerKelas)
        {{-- Judul untuk setiap kelas dengan jarak di bawahnya (mb-3) --}}
        <h4 class="mb-3 mt-4"><b>Kelas {{ $kelas }}</b></h4>
        <div class="row">
            @foreach ($kelompokPerKelas as $namaKelompok => $anggotas)
                {{-- Mengubah col-md-6 menjadi col-12 agar menjadi satu lajur --}}
                <div class="col-12 mb-3">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <strong>{{ $namaKelompok }}</strong>
                            </h3>
                            <div class="card-tools">
                                <span class="badge bg-primary">{{ count($anggotas) }} Anggota</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @foreach ($anggotas as $anggota)
                                    <li class="list-group-item">
                                        {{ $anggota->name }} ({{ $anggota->kode_admin }})
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                Belum ada data kelompok yang terbentuk.
            </div>
        </div>
    @endforelse
@endsection