@extends('layout_mahasiswa.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0 fw-bold">Hasil Penilaian Studi</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('mahasiswa.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hasil Penilaian</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')

    <div class="row justify-content-center">
        
        {{-- BAGIAN 1: NILAI KELOMPOK --}}
        <div class="col-md-6 mb-4">
            <div class="card card-outline card-success h-100 shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-people-fill me-2"></i>Nilai Kelompok 
                    </h3>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <p class="text-muted mb-3">Komponen penilaian yang dihitung:</p>
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> Hasil Proyek <strong>(Bobot 50%)</strong>
                            </li>
                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> Kerja Sama Tim <strong>(Bobot 30%)</strong>
                            </li>
                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> Presentasi Kelompok <strong>(Bobot 20%)</strong>
                            </li>
                        </ul>
                    </div>
                    
                    @php
                        // Logika Perhitungan (Tetap ada tapi tersembunyi)
                        $nk_proyek     = $nilaiKelompok['proyek'] ?? 0;
                        $nk_kerjasama  = $nilaiKelompok['kerjasama'] ?? 0;
                        $nk_presentasi = $nilaiKelompok['presentasi'] ?? 0;

                        // Hitung Skor Akhir Kelompok
                        $skorKelompok = ($nk_proyek * 0.5) + ($nk_kerjasama * 0.3) + ($nk_presentasi * 0.2);
                    @endphp

                    @if($nilaiKelompok)
                        <div class="alert alert-success text-center mb-0">
                            <h6 class="text-uppercase ls-1 mb-1">Total Skor Kelompok</h6>
                            <h1 class="fw-bold display-4 mb-0">{{ number_format($skorKelompok, 2) }}</h1>
                        </div>
                    @else
                        <div class="alert alert-secondary text-center mb-0">
                            Nilai belum tersedia
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- BAGIAN 2: SKOR AKHIR MAHASISWA (RANKING) --}}
        <div class="col-md-6 mb-4">
            <div class="card card-outline card-warning h-100 shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="bi bi-trophy-fill me-2"></i>Estimasi Skor Akhir</h3>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <p class="text-muted mb-3">Komponen penilaian yang dihitung:</p>
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-warning me-2"></i> Rata-rata Nilai Matkul <strong>(Bobot 50%)</strong>
                            </li>
                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-warning me-2"></i> Presentasi Individu <strong>(Bobot 20%)</strong>
                            </li>
                            <li class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-warning me-2"></i> Nilai Teman Sejawat <strong>(Bobot 30%)</strong>
                            </li>
                        </ul>
                    </div>

                    @php
                        // Logika Perhitungan (Tetap ada tapi tersembunyi)
                        $v_proyek     = $avgIndividu['proyek'] ?? 0;
                        $v_presentasi = $avgIndividu['presentasi'] ?? 0;
                        $v_sejawat    = $skorSejawat ?? 0;

                        // Hitung Skor Akhir Mahasiswa
                        $skorAkhir = ($v_proyek * 0.50) + 
                                     ($v_presentasi * 0.20) + 
                                     ($v_sejawat * 0.30);
                    @endphp

                    <div class="alert alert-warning text-center mb-0">
                        <h6 class="text-uppercase ls-1 mb-1 text-muted">Total Skor Akhir</h6>
                        <h1 class="fw-bold display-4 mb-0">{{ number_format($skorAkhir, 2) }}</h1>
                        <small class="text-muted">Digunakan untuk penentuan Ranking</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection