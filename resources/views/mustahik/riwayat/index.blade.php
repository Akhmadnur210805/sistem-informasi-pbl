@extends('layout_mustahik.app')

@section('content-header')
    <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a4321; letter-spacing: -0.5px;">Riwayat Pengajuan</h4>
            <p class="text-muted small mb-0">Pantau dan lacak status permohonan bantuan Anda di sini.</p>
        </div>
        <div class="d-none d-sm-block">
            <a href="{{ route('mustahik.dashboard') }}" class="btn btn-white border rounded-pill px-4 py-2 shadow-sm text-success fw-medium" style="font-size: 0.85rem;">
                <i class="bi bi-plus-circle me-1"></i> Buat Pengajuan Baru
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid pb-5">

    {{-- KARTU STATISTIK RINGKASAN --}}
    <div class="row g-4 mb-5">
        {{-- Card Menunggu --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm elegant-stat-card bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; background-color: #fffbeb; color: #f59e0b;">
                        <i class="bi bi-hourglass-split fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-medium mb-1 text-uppercase tracking-wider">Sedang Diproses</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ $riwayat->where('status', 'menunggu')->count() }} <span class="fs-6 fw-normal text-muted">Berkas</span></h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Disetujui --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm elegant-stat-card bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; background-color: #f0fdf4; color: #16a34a;">
                        <i class="bi bi-check-circle-fill fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-medium mb-1 text-uppercase tracking-wider">Disetujui</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ $riwayat->where('status', 'disetujui')->count() }} <span class="fs-6 fw-normal text-muted">Berkas</span></h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Ditolak --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm elegant-stat-card bg-white h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; background-color: #fef2f2; color: #ef4444;">
                        <i class="bi bi-x-circle-fill fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-medium mb-1 text-uppercase tracking-wider">Ditolak / Batal</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ $riwayat->where('status', 'ditolak')->count() }} <span class="fs-6 fw-normal text-muted">Berkas</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL DATA RIWAYAT --}}
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
        <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0" style="color: #1f2937;">Daftar Permohonan Anda</h5>
            <span class="badge bg-light text-secondary px-3 py-2 rounded-pill border">
                Total: {{ $riwayat->count() }} Data
            </span>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 custom-table">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3 fw-semibold small text-uppercase" style="letter-spacing: 0.5px;">No. Registrasi</th>
                            <th class="py-3 fw-semibold small text-uppercase" style="letter-spacing: 0.5px;">Program Bantuan</th>
                            <th class="py-3 fw-semibold small text-uppercase" style="letter-spacing: 0.5px;">Tanggal Pengajuan</th>
                            <th class="py-3 fw-semibold small text-uppercase" style="letter-spacing: 0.5px;">Status</th>
                            <th class="pe-4 py-3 fw-semibold small text-uppercase text-center" style="letter-spacing: 0.5px;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                            @php
                                // Logika Warna Dinamis Mengikuti Dashboard Utama
                                $icon = 'bi-box-seam'; $themeColor = '#16a34a'; $bgSoft = '#f0fdf4';
                                if($item->kategoriBantuan->jenis_form == 'pendidikan') { 
                                    $icon = 'bi-mortarboard'; $themeColor = '#10b981'; $bgSoft = '#ecfdf5'; 
                                } elseif($item->kategoriBantuan->jenis_form == 'kesehatan') { 
                                    $icon = 'bi-heart-pulse'; $themeColor = '#ef4444'; $bgSoft = '#fef2f2'; 
                                } elseif($item->kategoriBantuan->jenis_form == 'ekonomi') { 
                                    $icon = 'bi-shop'; $themeColor = '#f59e0b'; $bgSoft = '#fffbeb'; 
                                } elseif($item->kategoriBantuan->jenis_form == 'dakwah') { 
                                    $icon = 'bi-megaphone'; $themeColor = '#0ea5e9'; $bgSoft = '#f0f9ff'; 
                                } elseif($item->kategoriBantuan->jenis_form == 'kemanusiaan') { 
                                    $icon = 'bi-house-heart'; $themeColor = '#8b5cf6'; $bgSoft = '#f5f3ff'; 
                                }
                            @endphp

                        <tr class="transition-all">
                            {{-- Kolom 1: Nomor Registrasi --}}
                            <td class="ps-4 py-3">
                                <span class="fw-bold text-dark d-block mb-1">{{ $item->nomor_pengajuan }}</span>
                                <span class="badge bg-light text-secondary border font-monospace px-2 py-1">ID: #{{ $item->id }}</span>
                            </td>
                            
                            {{-- Kolom 2: Kategori Program --}}
                            <td class="py-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px; background-color: {{ $bgSoft }}; color: {{ $themeColor }};">
                                        <i class="bi {{ $icon }}" style="font-size: 1.1rem;"></i>
                                    </div>
                                    <span class="fw-semibold text-dark">{{ $item->kategoriBantuan->nama_bantuan }}</span>
                                </div>
                            </td>
                            
                            {{-- Kolom 3: Tanggal --}}
                            <td class="py-3 text-secondary">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar4 text-muted me-2"></i>
                                    {{ $item->created_at->translatedFormat('d F Y') }}
                                </div>
                            </td>
                            
                            {{-- Kolom 4: Status --}}
                            <td class="py-3">
                                @if($item->status == 'menunggu')
                                    <span class="badge rounded-pill px-3 py-2 fw-medium border" style="background-color: #fffbeb; color: #d97706; border-color: #fde68a !important;">
                                        <i class="bi bi-hourglass-split me-1"></i> Diproses
                                    </span>
                                @elseif($item->status == 'disetujui')
                                    <span class="badge rounded-pill px-3 py-2 fw-medium border" style="background-color: #f0fdf4; color: #15803d; border-color: #bbf7d0 !important;">
                                        <i class="bi bi-check-circle-fill me-1"></i> Disetujui
                                    </span>
                                @else
                                    <span class="badge rounded-pill px-3 py-2 fw-medium border" style="background-color: #fef2f2; color: #b91c1c; border-color: #fecaca !important;">
                                        <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                            
                            {{-- Kolom 5: Aksi --}}
                            <td class="pe-4 py-3 text-center">
                                <a href="{{ route('mustahik.pengajuan.detail', $item->id) }}" class="btn btn-sm btn-light border rounded-pill px-4 fw-semibold text-success hover-success transition-all shadow-sm">
                                    Lihat Detail <i class="bi bi-arrow-right-short align-middle fs-5 ms-1" style="margin-right: -5px;"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        {{-- Keadaan Kosong (Empty State) --}}
                        <tr>
                            <td colspan="5" class="text-center border-0">
                                <div class="py-5 d-flex flex-column align-items-center justify-content-center">
                                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="bi bi-inbox" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-1">Riwayat Masih Kosong</h5>
                                    <p class="text-muted small mb-3">Anda belum pernah mengajukan program bantuan apapun.</p>
                                    <a href="{{ route('mustahik.dashboard') }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-medium">
                                        Eksplor Program Bantuan
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS Custom untuk Riwayat Ala Aplikasi Premium */
    
    .elegant-stat-card {
        border-radius: 20px !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .elegant-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }
    
    .tracking-wider {
        letter-spacing: 0.05em;
    }

    /* Kustomisasi Tabel */
    .custom-table th {
        border-bottom: 1px solid #f3f4f6;
        font-weight: 600;
    }
    .custom-table td {
        border-bottom: 1px solid #f9fafb;
        vertical-align: middle;
    }
    
    /* Efek Hover Baris Tabel */
    .transition-all {
        transition: all 0.2s ease;
    }
    .custom-table tbody tr:hover {
        background-color: #f8fafc;
        transform: scale(1.001);
    }

    /* Efek Tombol Detail */
    .hover-success:hover {
        background-color: #16a34a !important;
        color: white !important;
        border-color: #16a34a !important;
    }
    
    .font-monospace {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }
</style>
@endsection