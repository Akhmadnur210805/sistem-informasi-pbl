@extends('layout_mustahik.app')

@section('content-header')
    <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a4321; letter-spacing: -0.5px;">Pusat Layanan</h4>
            <p class="text-muted small mb-0">Sistem Informasi Pengajuan Bantuan BAZNAS</p>
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
    
    {{-- HERO BANNER - LIGHT & ELEGANT STYLE --}}
    <div class="card border-0 mb-5 shadow-sm overflow-hidden" style="border-radius: 20px; background: linear-gradient(120deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #bbf7d0 !important;">
        <div class="card-body p-4 p-lg-5 d-flex flex-column flex-md-row align-items-center position-relative">
            <i class="bi bi-quote position-absolute text-success opacity-10" style="font-size: 8rem; right: 5%; top: -20px;"></i>
            
            <div class="d-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm mb-4 mb-md-0 me-md-4 flex-shrink-0" style="width: 80px; height: 80px; border: 2px solid #22c55e;">
                <i class="bi bi-person-fill text-success" style="font-size: 2.5rem;"></i>
            </div>
            
            <div class="text-center text-md-start z-1">
                <span class="badge bg-success bg-opacity-10 text-success mb-2 px-3 py-1 rounded-pill border border-success border-opacity-25" style="font-size: 0.75rem;">
                    Portal Mustahik
                </span>
                <h3 class="fw-bold mb-2" style="color: #14532d; letter-spacing: -0.5px;">
                    Assalamu'alaikum, {{ explode(' ', trim($user->name))[0] }}.
                </h3>
                <p class="mb-0" style="color: #166534; font-size: 0.95rem; max-width: 650px; line-height: 1.6;">
                    Semoga harimu dipenuhi keberkahan. Silakan pilih kategori program bantuan di bawah ini. Pastikan Anda telah menyiapkan dokumen persyaratan (KTP, KK, & SKTM).
                </p>
            </div>
        </div>
    </div>

    {{-- JUDUL SEKSI --}}
    <div class="d-flex align-items-center mb-4">
        <div class="bg-success rounded-pill me-3" style="width: 6px; height: 24px;"></div>
        <h5 class="fw-bold mb-0" style="color: #1f2937;">Daftar Program Bantuan</h5>
    </div>
    
    {{-- GRID PROGRAM BANTUAN --}}
    <div class="row g-4"> 
        @forelse($daftarBantuan as $bantuan)
            @php
                // WARNA DINAMIS: Memberikan warna berbeda agar tidak terlalu polos
                $icon = 'bi-box-seam'; $themeColor = '#16a34a'; $bgSoft = '#f0fdf4';
                
                if($bantuan->jenis_form == 'pendidikan') { 
                    $icon = 'bi-mortarboard'; $themeColor = '#10b981'; $bgSoft = '#ecfdf5'; // Hijau Tosca
                } elseif($bantuan->jenis_form == 'kesehatan') { 
                    $icon = 'bi-heart-pulse'; $themeColor = '#ef4444'; $bgSoft = '#fef2f2'; // Merah
                } elseif($bantuan->jenis_form == 'ekonomi') { 
                    $icon = 'bi-shop'; $themeColor = '#f59e0b'; $bgSoft = '#fffbeb'; // Kuning/Orange
                } elseif($bantuan->jenis_form == 'dakwah') { 
                    $icon = 'bi-megaphone'; $themeColor = '#0ea5e9'; $bgSoft = '#f0f9ff'; // Biru
                } elseif($bantuan->jenis_form == 'kemanusiaan') { 
                    $icon = 'bi-house-heart'; $themeColor = '#8b5cf6'; $bgSoft = '#f5f3ff'; // Ungu
                }
            @endphp

        <div class="col-md-6 col-xl-4 d-flex">
            {{-- Injeksi warna dinamis melalui CSS Variable inline --}}
            <div class="card elegant-card w-100 border-0 flex-column bg-white" style="--theme-color: {{ $themeColor }}; --bg-soft: {{ $bgSoft }};">
                <div class="card-body p-4 p-xl-5 d-flex flex-column h-100">
                    
                    {{-- Header Kartu (Ikon & Badge Dinamis) --}}
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="elegant-icon-box shadow-sm">
                            <i class="bi {{ $icon }}"></i>
                        </div>
                        <span class="badge rounded-pill px-3 py-2 fw-medium elegant-badge">
                            Tersedia
                        </span>
                    </div>
                    
                    {{-- Konten Kartu --}}
                    <h5 class="fw-bold text-dark mb-2" style="font-size: 1.15rem;">{{ $bantuan->nama_bantuan }}</h5>
                    <div class="text-secondary mb-4 flex-grow-1 elegant-desc" style="font-size: 0.9rem; line-height: 1.6;">
                        {{ Str::limit(strip_tags($bantuan->deskripsi), 110) }}
                    </div>
                    
                    {{-- Aksi --}}
                    <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
                        {{-- PERBAIKAN BUG: Memasukkan data-toggle dan data-target (Format BS4) --}}
                        <button type="button" class="btn btn-link text-decoration-none p-0 fw-medium btn-detail-link" 
                                data-toggle="modal" data-target="#modalDetail{{ $bantuan->id }}" 
                                data-bs-toggle="modal" data-bs-target="#modalDetail{{ $bantuan->id }}"
                                style="font-size: 0.9rem;">
                            Lihat Syarat <i class="bi bi-chevron-right fs-6 align-middle"></i>
                        </button>
                        
                        {{-- Tombol Utama Ajukan --}}
                        <a href="{{ route('mustahik.pengajuan.create', $bantuan->id) }}" class="btn rounded-pill px-4 py-2 fw-bold shadow-sm btn-dynamic-solid">
                            Ajukan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL DETAIL --}}
        <div class="modal fade" id="modalDetail{{ $bantuan->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; --theme-color: {{ $themeColor }}; --bg-soft: {{ $bgSoft }};">
                    <div class="modal-header border-0 pb-0 px-4 pt-4">
                        <div class="d-flex align-items-center">
                            <div class="elegant-icon-box me-3" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                <i class="bi {{ $icon }}"></i>
                            </div>
                            <h5 class="modal-title fw-bold text-dark mb-0">{{ $bantuan->nama_bantuan }}</h5>
                        </div>
                        <button type="button" class="close text-muted" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="background:none; border:none; font-size:1.5rem;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body p-4 px-4">
                        <h6 class="fw-bold text-dark mb-2">Penjelasan Program:</h6>
                        <div class="bg-light p-3 rounded-3 mb-4 text-secondary border" style="font-size: 0.9rem; line-height: 1.7;">
                            {!! nl2br(e($bantuan->deskripsi)) !!}
                        </div>
                        
                        <h6 class="fw-bold text-dark mb-2 d-flex align-items-center" style="color: var(--theme-color) !important;">
                            <i class="bi bi-check-circle-fill me-2"></i> Dokumen Wajib:
                        </h6>
                        <div class="p-3 rounded-3" style="background-color: var(--bg-soft); border: 1px solid var(--theme-color);">
                            <ul class="m-0 ps-3" style="font-size: 0.9rem; line-height: 1.8; color: #374151;">
                                <li>Scan / Foto <strong>KTP Asli</strong> Pemohon</li>
                                <li>Scan / Foto <strong>Kartu Keluarga (KK) Asli</strong></li>
                                <li><strong>SKTM</strong> dari RT/Lurah/Kepala Desa Terbaru</li>
                                <li>Berkas pendukung tambahan sesuai jenis form.</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-0 p-4 pt-0 d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-medium border flex-grow-1" data-dismiss="modal" data-bs-dismiss="modal">Tutup</button>
                        <a href="{{ route('mustahik.pengajuan.create', $bantuan->id) }}" class="btn rounded-pill px-4 fw-medium flex-grow-1 shadow-sm btn-dynamic-solid">
                            Lanjut Ajukan Bantuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        @empty
        <div class="col-12">
            <div class="text-center py-5 bg-white rounded-4 shadow-sm border" style="min-height: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-folder-x" style="font-size: 2.5rem;"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Katalog Kosong</h5>
                <p class="text-muted small mb-0" style="max-width: 400px;">Mohon maaf, saat ini BAZNAS belum membuka program bantuan. Silakan pantau sistem ini secara berkala.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
    /* =======================================================
       ELEGANT & COLORFUL CSS (Premium App Style)
       ======================================================= */
    
    .elegant-card {
        border-radius: 20px !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0,0,0,0.05) !important;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .elegant-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.06);
        border-color: var(--theme-color) !important;
    }

    /* Ikon dan Badge mengikuti warna kategori */
    .elegant-icon-box {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background-color: var(--bg-soft); 
        color: var(--theme-color); 
        font-size: 1.5rem;
    }
    
    .elegant-badge {
        background-color: var(--bg-soft);
        color: var(--theme-color);
        border: 1px solid var(--theme-color);
        opacity: 0.9;
    }

    .elegant-desc {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Tombol Teks Detail */
    .btn-detail-link {
        color: var(--theme-color);
        transition: all 0.2s ease;
    }
    .btn-detail-link:hover {
        filter: brightness(0.8);
        transform: translateX(3px);
        color: var(--theme-color);
    }

    /* Tombol Solid Dinamis */
    .btn-dynamic-solid {
        background-color: var(--theme-color);
        color: #ffffff !important;
        border: none;
        transition: all 0.2s ease;
    }
    .btn-dynamic-solid:hover {
        filter: brightness(0.9);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15) !important;
    }
</style>
@endsection