@extends('layout_dosen.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Penilaian Kelompok</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Penilaian Kelompok</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header"><h3 class="card-title">Formulir Penilaian Akhir Kelompok</h3></div>
        <div class="card-body">
            <form action="{{ route('dosen.penilaian_kelompok.store') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 5%;">Kelas</th>
                                <th style="width: 10%;">Periode</th> {{-- KOLOM BARU --}}
                                <th style="width: 15%;">Kelompok</th>
                                <th>Nilai Hasil Proyek</th>
                                <th>Nilai Kerja Sama</th>
                                <th>Nilai Presentasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kelompoks as $kelompok)
                                @php
                                    $key = $kelompok->kelas . '|' . $kelompok->kelompok;
                                    $nilai = $nilaiSudahAda->get($key);
                                    // Ambil periode dari data yang dikirim controller
                                    $periodeRaw = $penugasanDosen[$kelompok->kelas]->periode ?? '-';
                                    $periodeLabel = $periodeRaw == 'sebelum_uts' ? 'Sebelum UTS' : 'Setelah UTS';
                                    $badgeClass = $periodeRaw == 'sebelum_uts' ? 'bg-primary' : 'bg-info text-dark';
                                @endphp
                                <tr>
                                    <td class="text-center fw-bold">{{ $kelompok->kelas }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $badgeClass }}">{{ $periodeLabel }}</span>
                                    </td>
                                    <td><strong>{{ $kelompok->kelompok }}</strong></td>
                                    <td>
                                        <input type="number" class="form-control text-center" 
                                               name="penilaian[{{$key}}][nilai_hasil_proyek]" 
                                               value="{{ $nilai->nilai_hasil_proyek ?? '' }}" 
                                               min="0" max="100" placeholder="0">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control text-center" 
                                               name="penilaian[{{$key}}][nilai_kerja_sama]" 
                                               value="{{ $nilai->nilai_kerja_sama ?? '' }}" 
                                               min="0" max="100" placeholder="0">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control text-center" 
                                               name="penilaian[{{$key}}][nilai_presentasi_kelompok]" 
                                               value="{{ $nilai->nilai_presentasi_kelompok ?? '' }}" 
                                               min="0" max="100" placeholder="0">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-4">
                                        <p class="text-muted mb-0">Tidak ada kelompok mahasiswa yang terdaftar di kelas Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($kelompoks->isNotEmpty())
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Semua Nilai
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection