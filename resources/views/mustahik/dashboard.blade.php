@extends('layout_mustahik.app')

@section('content-header')
    <div class="row align-items-center mb-4">
        <div class="col-sm-6">
            <h3 class="fw-bold text-success"><i class="bi bi-house-door-fill me-2"></i>Beranda Mustahik</h3>
        </div>
        <div class="col-sm-6 text-end">
            <span class="badge bg-success p-2 px-3 rounded-pill shadow-sm" style="background-color: #1e5128 !important; color: white;">
                <i class="bi bi-calendar3 me-1"></i> {{ date('d F Y') }}
            </span>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    {{-- Banner Selamat Datang --}}
    <div class="card border-0 shadow-sm text-white mb-4" style="background: linear-gradient(45deg, #1e5128, #4e944f); border-radius: 15px;">
        <div class="card-body p-4 d-flex align-items-center">
            <div class="me-4 d-none d-md-block">
                <i class="bi bi-person-check" style="font-size: 3.5rem;"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-1">Assalamu'alaikum, {{ $user->name }}!</h2>
                <p class="mb-0 opacity-75">Silakan pilih kategori bantuan yang Anda butuhkan melalui sistem SIMPATIK.</p>
            </div>
        </div>
    </div>

    {{-- Daftar Program Bantuan --}}
    <h5 class="fw-bold text-dark mb-4"><i class="bi bi-grid-fill me-2 text-success"></i>Pilih Program Bantuan</h5>
    <div class="row">
        @forelse($daftarBantuan as $bantuan)
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2 rounded-3 me-3" style="background-color: #d1e7dd; color: #1e5128;">
                            <i class="bi bi-patch-check-fill fs-4"></i>
                        </div>
                        <h6 class="fw-bold mb-0 text-dark">{{ $bantuan->nama_bantuan }}</h6>
                    </div>
                    
                    {{-- Deskripsi singkat --}}
                    <p class="text-muted small mb-3">
                        {{ Str::limit($bantuan->deskripsi, 100) }}
                    </p>
                    
                    {{-- Tombol Pemicu Modal (Disesuaikan untuk Bootstrap 4) --}}
                    <button type="button" class="btn btn-link text-success p-0 small fw-bold text-decoration-none mb-3" 
                            data-toggle="modal" 
                            data-target="#modalDetail{{ $bantuan->id }}">
                        Baca Penjelasan Selengkapnya <i class="bi bi-info-circle ms-1"></i>
                    </button>
                </div>
                
                <div class="card-footer bg-white border-0 pb-4">
                    <a href="{{ route('mustahik.pengajuan.create', $bantuan->id) }}" class="btn btn-success w-100 rounded-pill fw-bold shadow-sm py-2" style="background-color: #1e5128; border: none; color: white;">
                        Mulai Ajukan <i class="bi bi-arrow-right-short ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Struktur Modal (Disesuaikan untuk Bootstrap 4) --}}
        <div class="modal fade" id="modalDetail{{ $bantuan->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $bantuan->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0" style="border-radius: 15px;">
                    <div class="modal-header border-0 bg-light p-4">
                        <h5 class="modal-title fw-bold text-success" id="modalLabel{{ $bantuan->id }}">
                            <i class="bi bi-info-square-fill me-2"></i>Detail {{ $bantuan->nama_bantuan }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <p class="text-dark" style="text-align: justify; line-height: 1.6;">
                            {{ $bantuan->deskripsi }}
                        </p>
                        <div class="alert alert-success border-0 small mb-0" style="background-color: #f0fdf4; color: #1e5128;">
                            <i class="bi bi-lightbulb-fill me-2"></i> Pastikan Anda telah menyiapkan berkas pendukung sesuai dengan syarat program ini sebelum mengajukan.
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-dismiss="modal">Tutup</button>
                        <a href="{{ route('mustahik.pengajuan.create', $bantuan->id) }}" class="btn btn-success rounded-pill px-4 fw-bold" style="background-color: #1e5128; color: white;">Lanjut Ajukan</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 bg-white rounded-4 shadow-sm">
            <i class="bi bi-clipboard-x display-4 text-muted mb-3 d-block"></i>
            <h6 class="text-muted">Maaf, program bantuan belum tersedia saat ini.</h6>
        </div>
        @endforelse
    </div>
</div>

<style>
    .card { transition: transform 0.2s ease-in-out; }
    .card:hover { transform: translateY(-5px); }
    .btn-link:hover { color: #153e1f !important; }
</style>
@endsection