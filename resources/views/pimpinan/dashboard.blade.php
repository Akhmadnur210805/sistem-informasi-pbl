@extends('layout_pimpinan.app') 

@section('content-header')
    <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a4321; letter-spacing: -0.5px;">Dashboard Eksekutif</h4>
            <p class="text-muted small mb-0">Ringkasan Sistem Informasi Pengajuan Bantuan BAZNAS</p>
        </div>
        <div class="d-none d-sm-block">
            <div class="bg-white border rounded-pill px-4 py-2 shadow-sm d-flex align-items-center text-secondary" style="font-size: 0.85rem;">
                <i class="bi bi-calendar-event text-success me-2"></i> 
                <span class="fw-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid pb-5">
    
    {{-- BANNER SELAMAT DATANG PIMPINAN --}}
    <div class="card border-0 mb-5 shadow-sm overflow-hidden" style="border-radius: 20px; background: linear-gradient(135deg, #1e5128 0%, #2d8a4e 100%);">
        <div class="card-body p-4 p-lg-5 position-relative">
            {{-- Dekorasi Abstrak --}}
            <i class="bi bi-graph-up-arrow position-absolute opacity-10" style="font-size: 10rem; right: 5%; top: -30px; color: white;"></i>
            
            <div class="d-flex align-items-center position-relative z-1">
                <div class="d-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm me-4 flex-shrink-0" style="width: 75px; height: 75px;">
                    <i class="bi bi-person-badge-fill text-success" style="font-size: 2.5rem;"></i>
                </div>
                <div class="text-white">
                    <span class="badge bg-warning text-dark mb-2 px-3 py-1 rounded-pill fw-bold shadow-sm" style="font-size: 0.75rem;">
                        <i class="bi bi-shield-lock me-1"></i> Akses Pimpinan
                    </span>
                    <h3 class="fw-bold mb-1" style="letter-spacing: -0.5px;">
                        Selamat Datang, {{ Auth::user()->name ?? 'Ketua BAZNAS' }}
                    </h3>
                    <p class="mb-0 text-white-50" style="font-size: 0.95rem; max-width: 600px;">
                        Berikut adalah ringkasan data statistik pengajuan bantuan pada sistem SIMPATIK BAZNAS Kabupaten Tanah Laut.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- KARTU STATISTIK (OVERVIEW) --}}
    <div class="d-flex align-items-center mb-4">
        <div class="bg-success rounded-pill me-3" style="width: 6px; height: 24px;"></div>
        <h5 class="fw-bold mb-0" style="color: #1f2937;">Statistik Pengajuan</h5>
    </div>

    <div class="row g-4 mb-5">
        {{-- Card 1: Total Pengajuan --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card border-0 bg-white h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-center">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon-box" style="background-color: #f3f4f6; color: #4b5563;">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                    </div>
                    <p class="text-muted small fw-bold mb-1 text-uppercase" style="letter-spacing: 1px;">Total Pengajuan</p>
                    <h2 class="fw-bold mb-0 text-dark">{{ $totalPengajuan ?? 0 }}</h2>
                </div>
            </div>
        </div>

        {{-- Card 2: Menunggu Verifikasi --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card border-0 bg-white h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-center">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon-box" style="background-color: #fffbeb; color: #d97706;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                    <p class="text-muted small fw-bold mb-1 text-uppercase" style="letter-spacing: 1px;">Menunggu Proses</p>
                    <h2 class="fw-bold mb-0 text-dark">{{ $pengajuanMenunggu ?? 0 }}</h2>
                </div>
            </div>
        </div>

        {{-- Card 3: Disetujui --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card border-0 bg-white h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-center">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon-box" style="background-color: #f0fdf4; color: #15803d;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                    <p class="text-muted small fw-bold mb-1 text-uppercase" style="letter-spacing: 1px;">Telah Disetujui</p>
                    <h2 class="fw-bold mb-0 text-dark">{{ $pengajuanDisetujui ?? 0 }}</h2>
                </div>
            </div>
        </div>

        {{-- Card 4: Ditolak --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card border-0 bg-white h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-center">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon-box" style="background-color: #fef2f2; color: #b91c1c;">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                    </div>
                    <p class="text-muted small fw-bold mb-1 text-uppercase" style="letter-spacing: 1px;">Ditolak</p>
                    <h2 class="fw-bold mb-0 text-dark">{{ $pengajuanDitolak ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- MENU PINTASAN LAPORAN --}}
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0" style="color: #1f2937;">Akses Cepat Pimpinan</h5>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <div class="row g-3">
                        
                        {{-- KARTU 1: CETAK LAPORAN (Sudah dihubungkan ke rute pimpinan.laporan.index) --}}
                        <div class="col-md-6">
                            <a href="{{ route('pimpinan.laporan.index') }}" class="text-decoration-none">
                                <div class="p-4 rounded-4 border bg-light report-card d-flex align-items-center">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                                        <i class="bi bi-printer-fill fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">Cetak Laporan Pengajuan</h6>
                                        <p class="text-muted small mb-0">Unduh rekap data pengajuan dalam format PDF.</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- KARTU 2: PANTAU MUSTAHIK --}}
                        <div class="col-md-6">
                            <a href="#" class="text-decoration-none" title="Sedang dalam pengembangan">
                                <div class="p-4 rounded-4 border bg-light report-card d-flex align-items-center">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                                        <i class="bi bi-pie-chart-fill fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">Pantau Data Mustahik</h6>
                                        <p class="text-muted small mb-0">Lihat total dan data demografi Mustahik terdaftar.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    /* CSS Khusus Pimpinan */
    
    .stat-card {
        border-radius: 20px !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0,0,0,0.05) !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important;
    }

    .icon-box {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-size: 1.4rem;
    }

    .report-card {
        transition: all 0.2s ease;
    }
    
    .report-card:hover {
        background-color: #f0fdf4 !important;
        border-color: #bbf7d0 !important;
        transform: translateX(5px);
    }
</style>
@endsection