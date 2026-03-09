@extends('layout_mustahik.app')

@section('content')
@php
    // LOGIKA WARNA & IKON DINAMIS
    $jenis = $pengajuan->kategoriBantuan->jenis_form ?? 'umum';
    $icon = 'bi-box-seam'; $themeColor = '#16a34a'; $bgSoft = '#f0fdf4';
    
    if($jenis == 'pendidikan') { 
        $icon = 'bi-mortarboard'; $themeColor = '#10b981'; $bgSoft = '#ecfdf5'; 
    } elseif($jenis == 'kesehatan') { 
        $icon = 'bi-heart-pulse'; $themeColor = '#ef4444'; $bgSoft = '#fef2f2'; 
    } elseif($jenis == 'ekonomi') { 
        $icon = 'bi-shop'; $themeColor = '#f59e0b'; $bgSoft = '#fffbeb'; 
    } elseif($jenis == 'dakwah') { 
        $icon = 'bi-megaphone'; $themeColor = '#0ea5e9'; $bgSoft = '#f0f9ff'; 
    } elseif($jenis == 'kemanusiaan') { 
        $icon = 'bi-house-heart'; $themeColor = '#8b5cf6'; $bgSoft = '#f5f3ff'; 
    }

    // LOGIKA LABEL DOKUMEN DINAMIS
    $labelFoto = 'Pas Foto';
    $labelKTP = 'Kartu Tanda Penduduk';
    $labelPendukung = 'Dokumen Pendukung';

    if ($jenis == 'pendidikan') {
        $labelFoto = 'Foto Siswa / Mahasiswa';
        $labelKTP = 'KTP Ortu & Siswa';
        $labelPendukung = 'Berkas Pendidikan (PDF)';
    } elseif ($jenis == 'kesehatan') {
        $labelFoto = 'Foto Kondisi Pasien';
        $labelKTP = 'KTP Suami & Istri';
        $labelPendukung = 'Berkas Medis (PDF)';
    } elseif ($jenis == 'ekonomi') {
        $labelFoto = 'Foto Tempat Usaha';
        $labelKTP = 'KTP Suami & Istri';
        $labelPendukung = 'Proposal & SKU (PDF)';
    } elseif ($jenis == 'dakwah') {
        $labelKTP = 'KTP Penanggung Jawab';
        $labelPendukung = 'Proposal Kegiatan (PDF)';
    } elseif ($jenis == 'kemanusiaan') {
        $labelFoto = 'Foto Diri / Kejadian';
        $labelPendukung = 'Berkas Permohonan (PDF)';
    }
@endphp

<div class="container-fluid py-4 pb-5" style="--theme-color: {{ $themeColor }}; --bg-soft: {{ $bgSoft }};">
    
    {{-- HEADER KEMBALI --}}
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('mustahik.riwayat') }}" class="btn btn-white border shadow-sm rounded-circle d-flex align-items-center justify-content-center me-3 hover-back" style="width: 45px; height: 45px;">
            <i class="bi bi-arrow-left fs-5 text-dark"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-1" style="color: #1f2937; letter-spacing: -0.5px;">Detail Pengajuan</h4>
            <div class="d-flex align-items-center text-muted small font-monospace">
                <i class="bi bi-upc-scan me-2"></i> ID: {{ $pengajuan->nomor_pengajuan }}
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- KOLOM KIRI: STATUS & FOTO UTAMA --}}
        <div class="col-lg-4">
            <div class="card elegant-card border-0 bg-white h-100 position-relative overflow-hidden">
                {{-- Aksen Garis Atas Dinamis --}}
                <div class="position-absolute top-0 start-0 w-100" style="height: 5px; background-color: var(--theme-color);"></div>
                
                <div class="card-body p-4 p-xl-5 text-center d-flex flex-column align-items-center">
                    
                    {{-- Status Badge --}}
                    <div class="mb-5 w-100 text-center">
                        <span class="text-muted small fw-bold d-block mb-3 text-uppercase" style="letter-spacing: 1px;">Status Permohonan</span>
                        @if($pengajuan->status == 'menunggu')
                            <div class="d-inline-flex px-4 py-2 rounded-pill border align-items-center" style="background-color: #fffbeb; color: #d97706; border-color: #fde68a !important;">
                                <i class="bi bi-hourglass-split fs-5 me-2"></i>
                                <span class="fw-bold">Sedang Diproses</span>
                            </div>
                        @elseif($pengajuan->status == 'disetujui')
                            <div class="d-inline-flex px-4 py-2 rounded-pill border align-items-center" style="background-color: #f0fdf4; color: #15803d; border-color: #bbf7d0 !important;">
                                <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                                <span class="fw-bold">Telah Disetujui</span>
                            </div>
                        @else
                            <div class="d-inline-flex flex-column p-3 rounded-4 border w-100 align-items-center" style="background-color: #fef2f2; color: #b91c1c; border-color: #fecaca !important;">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="bi bi-x-circle-fill fs-5 me-2"></i>
                                    <span class="fw-bold">Ditolak / Dibatalkan</span>
                                </div>
                                <small style="opacity: 0.8;">Syarat/ketentuan tidak terpenuhi</small>
                            </div>
                        @endif
                    </div>

                    {{-- Foto Pemohon / Pendukung (DESAIN BARU NATURAL) --}}
                    <div class="w-100 mb-4 text-center">
                        <span class="text-muted small fw-bold d-block mb-3 text-uppercase" style="letter-spacing: 1px;">{{ $labelFoto }}</span>
                        
                        @if($pengajuan->pas_foto)
                            <a href="{{ asset('storage/' . $pengajuan->pas_foto) }}" target="_blank" class="d-block photo-hover">
                                <img src="{{ asset('storage/' . $pengajuan->pas_foto) }}" alt="Foto" class="img-fluid w-100 border shadow-sm" style="border-radius: 20px; max-height: 280px; object-fit: contain; background-color: #f8fafc; padding: 4px;">
                            </a>
                            <small class="text-muted mt-2 d-inline-block"><i class="bi bi-zoom-in me-1"></i> Klik foto untuk memperbesar</small>
                        @else
                            <div class="rounded-4 bg-light border d-flex flex-column align-items-center justify-content-center text-muted mx-auto" style="height: 200px;">
                                <i class="bi bi-folder-x fs-1 mb-2 opacity-50"></i>
                                <span class="small">Tanpa Lampiran Foto</span>
                            </div>
                        @endif
                    </div>

                    {{-- Info Program Pendek --}}
                    <div class="w-100 mt-auto bg-light rounded-4 p-3 border text-start">
                        <div class="d-flex align-items-center mb-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 35px; height: 35px; background-color: var(--bg-soft); color: var(--theme-color);">
                                <i class="bi {{ $icon }} small"></i>
                            </div>
                            <span class="fw-bold text-dark lh-sm">{{ $pengajuan->kategoriBantuan->nama_bantuan }}</span>
                        </div>
                        <div class="d-flex align-items-center text-muted ms-1" style="font-size: 0.85rem;">
                            <i class="bi bi-calendar-event me-2"></i> Diajukan: {{ $pengajuan->created_at->translatedFormat('d M Y') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: DATA & DOKUMEN --}}
        <div class="col-lg-8">
            
            {{-- DATA PEMOHON (Desain List Rapi Ala Struk/Invoice) --}}
            <div class="card elegant-card border-0 mb-4 bg-white">
                <div class="card-header bg-transparent border-bottom px-4 py-3">
                    <h6 class="fw-bold mb-0" style="color: #1f2937;"><i class="bi bi-person-lines-fill text-muted me-2"></i> Informasi Pemohon</h6>
                </div>
                <div class="card-body p-4 px-xl-5">
                    
                    <div class="info-list">
                        <div class="row py-3 border-bottom border-light">
                            <div class="col-sm-4 text-muted small text-uppercase tracking-wider">Nama Lengkap</div>
                            <div class="col-sm-8 fw-semibold text-dark">{{ $pengajuan->nama_lengkap }}</div>
                        </div>
                        <div class="row py-3 border-bottom border-light">
                            <div class="col-sm-4 text-muted small text-uppercase tracking-wider">Alamat KTP / Domisili</div>
                            <div class="col-sm-8 text-dark">{{ $pengajuan->alamat_ktp }}</div>
                        </div>

                        {{-- Menampilkan data tambahan jika Form Umum --}}
                        @if($jenis == 'umum')
                        <div class="row py-3 border-bottom border-light">
                            <div class="col-sm-4 text-muted small text-uppercase tracking-wider">Jenis Kelamin</div>
                            <div class="col-sm-8 text-dark">{{ $pengajuan->jenis_kelamin }}</div>
                        </div>
                        <div class="row py-3 border-bottom border-light">
                            <div class="col-sm-4 text-muted small text-uppercase tracking-wider">Pekerjaan Saat Ini</div>
                            <div class="col-sm-8 text-dark">{{ $pengajuan->pekerjaan }}</div>
                        </div>
                        @endif
                    </div>

                    {{-- Deskripsi / Keterangan Kondisi --}}
                    <div class="mt-4 pt-2">
                        <div class="text-muted small text-uppercase tracking-wider mb-2">Rincian Pengajuan / Kondisi:</div>
                        <div class="p-4 rounded-4" style="background-color: #f8fafc; border-left: 4px solid var(--theme-color); border: 1px solid #f1f5f9; border-left-width: 4px;">
                            <div class="text-secondary" style="line-height: 1.8; font-size: 0.95rem;">
                                {!! nl2br(e($pengajuan->deskripsi_kondisi)) !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- DOKUMEN TERLAMPIR (Desain File Attachment Modern) --}}
            <div class="card elegant-card border-0 bg-white">
                <div class="card-header bg-transparent border-bottom px-4 py-3">
                    <h6 class="fw-bold mb-0" style="color: #1f2937;"><i class="bi bi-folder-check text-muted me-2"></i> Dokumen Lampiran</h6>
                </div>
                <div class="card-body p-4 px-xl-5">
                    <div class="row g-3">
                        
                        {{-- KTP --}}
                        @if($pengajuan->file_ktp)
                        <div class="col-md-6">
                            <a href="{{ asset('storage/' . $pengajuan->file_ktp) }}" target="_blank" class="text-decoration-none">
                                <div class="attachment-card p-3 rounded-4 border d-flex align-items-center h-100">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px; background-color: #f3f4f6; color: #4b5563;">
                                        <i class="bi bi-person-vcard fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 0.9rem;">{{ $labelKTP }}</h6>
                                        <small class="text-muted">Lihat Dokumen <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.7rem;"></i></small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif

                        {{-- KK --}}
                        @if($pengajuan->file_kk)
                        <div class="col-md-6">
                            <a href="{{ asset('storage/' . $pengajuan->file_kk) }}" target="_blank" class="text-decoration-none">
                                <div class="attachment-card p-3 rounded-4 border d-flex align-items-center h-100">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px; background-color: #f3f4f6; color: #4b5563;">
                                        <i class="bi bi-people fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 0.9rem;">Kartu Keluarga (KK)</h6>
                                        <small class="text-muted">Lihat Dokumen <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.7rem;"></i></small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif

                        {{-- SKTM --}}
                        @if($pengajuan->file_sktm)
                        <div class="col-md-6">
                            <a href="{{ asset('storage/' . $pengajuan->file_sktm) }}" target="_blank" class="text-decoration-none">
                                <div class="attachment-card p-3 rounded-4 border d-flex align-items-center h-100">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px; background-color: #f3f4f6; color: #4b5563;">
                                        <i class="bi bi-file-earmark-medical fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 0.9rem;">SKTM (Surat Tidak Mampu)</h6>
                                        <small class="text-muted">Lihat Dokumen <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.7rem;"></i></small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif

                        {{-- BERKAS PENDUKUNG / PROPOSAL (PDF) --}}
                        @if($pengajuan->file_pendukung)
                        <div class="col-md-6">
                            <a href="{{ asset('storage/' . $pengajuan->file_pendukung) }}" target="_blank" class="text-decoration-none">
                                <div class="attachment-card p-3 rounded-4 border d-flex align-items-center h-100" style="background-color: var(--bg-soft); border-color: var(--theme-color) !important; opacity: 0.9;">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0 bg-white shadow-sm" style="width: 50px; height: 50px; color: var(--theme-color);">
                                        <i class="bi bi-file-earmark-pdf-fill fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="fw-bold mb-1 text-truncate" style="color: var(--theme-color); font-size: 0.9rem;">{{ $labelPendukung }}</h6>
                                        <small style="color: var(--theme-color); opacity: 0.8;">Buka File PDF <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.7rem;"></i></small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* CSS Custom Detail Pengajuan Modern */
    
    .elegant-card {
        border-radius: 20px !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .tracking-wider {
        letter-spacing: 0.05em;
    }

    /* Efek Hover Tombol Kembali */
    .hover-back {
        transition: all 0.2s ease;
    }
    .hover-back:hover {
        background-color: #f3f4f6 !important;
        transform: translateX(-3px);
    }

    /* Efek Hover pada Foto */
    .photo-hover img {
        transition: all 0.3s ease;
    }
    .photo-hover:hover img {
        transform: scale(1.02);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        border-color: var(--theme-color) !important;
    }

    /* Hover File Dokumen (Attachment Card) */
    .attachment-card {
        background-color: #ffffff;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .attachment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px rgba(0,0,0,0.05);
        border-color: #d1d5db !important;
    }
    
    /* Agar list informasi tidak mepet */
    .info-list .row:last-child {
        border-bottom: none !important;
        padding-bottom: 0 !important;
    }
</style>
@endsection