@extends('layout_petugas.app')

@section('styles')
<style>
    /* Theme BAZNAS Green */
    :root {
        --baznas-green: #1e5128;
        --baznas-light: #4e944f;
        --baznas-soft: #d1e7dd;
    }

    .bg-baznas-gradient {
        background: linear-gradient(45deg, var(--baznas-green), var(--baznas-light));
        color: white;
    }

    .card-baznas {
        border-radius: 15px;
        border: none;
        transition: transform 0.3s ease;
    }

    .card-baznas:hover {
        transform: translateY(-5px);
    }

    .info-box-custom {
        border-radius: 12px;
        display: flex;
        padding: 20px;
        margin-bottom: 20px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .info-box-custom .icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 5rem;
        opacity: 0.2;
    }

    .table-baznas thead th {
        background-color: var(--baznas-soft);
        color: var(--baznas-green);
        border: none;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>
@endsection

@section('content-header')
    <div class="row align-items-center mb-4">
        <div class="col-sm-6">
            <h3 class="fw-bold" style="color: var(--baznas-green);">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard Petugas
            </h3>
            <p class="text-muted mb-0">Selamat datang kembali di Pusat Kendali SIMPATIK BAZNAS.</p>
        </div>
        <div class="col-sm-6 text-end">
            <span class="badge bg-baznas-gradient p-2 px-3 rounded-pill shadow-sm">
                <i class="bi bi-calendar3 me-2"></i>{{ date('d F Y') }}
            </span>
        </div>
    </div>
@endsection

@section('content')
    {{-- BARIS 1: INFO BOXES MEWAH --}}
    <div class="row">
        {{-- Total Mustahik --}}
        <div class="col-lg-4">
            <div class="info-box-custom shadow-sm" style="background: linear-gradient(45deg, #1e5128, #4e944f);">
                <div class="inner flex-grow-1">
                   <h2 class="fw-bold mb-0">{{ $jumlahMustahik }}</h2>
                   <p class="mb-0">Total Mustahik Terdaftar</p>
                </div>
                <i class="bi bi-people-fill icon-bg"></i>
            </div>
        </div>

        {{-- Total Pengajuan --}}
        <div class="col-lg-4">
            <div class="info-box-custom shadow-sm" style="background: linear-gradient(45deg, #116530, #21b6a8);">
                <div class="inner flex-grow-1">
                   <h2 class="fw-bold mb-0">{{ $jumlahPengajuan }}</h2>
                   <p class="mb-0">Total Pengajuan Masuk</p>
                </div>
                <i class="bi bi-envelope-open-heart icon-bg"></i>
            </div>
        </div>

        {{-- Total Disetujui --}}
        <div class="col-lg-4">
            <div class="info-box-custom shadow-sm" style="background: linear-gradient(45deg, #ff930f, #ffaa33);">
                <div class="inner flex-grow-1">
                    <h2 class="fw-bold mb-0">{{ $jumlahDisetujui }}</h2>
                    <p class="mb-0">Pengajuan Telah Disetujui</p>
                </div>
                <i class="bi bi-patch-check icon-bg"></i>
            </div>
        </div>
    </div>

    {{-- BARIS 2: TABEL ANTREAN PENGAJUAN --}}
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card card-baznas shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold text-dark">
                            <i class="bi bi-clock-history me-2 text-success"></i>Antrean Verifikasi Terbaru
                        </h5>
                        {{-- Tombol Lihat Semua Pengajuan Terhubung ke Rute LOG --}}
                        <a href="{{ route('petugas.log.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                            Lihat Semua Pengajuan
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-baznas">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 60px">#</th>
                                    <th class="text-start">Nama Mustahik</th>
                                    <th class="text-start">Kategori Bantuan</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($antreanTerbaru as $index => $item)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-start fw-bold text-dark">{{ $item->user->name }}</td>
                                    <td class="text-start text-muted">{{ $item->kategoriBantuan->nama_bantuan }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge status-badge bg-warning text-dark">
                                            <i class="bi bi-hourglass-split me-1"></i>Menunggu
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('petugas.verifikasi.show', $item->id) }}" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                            Verifikasi
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            <p class="mb-0">Alhamdulillah, semua antrean sudah diproses.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    {{-- Tombol Buka Manajemen Terhubung ke Rute MANAGEMENT --}}
                    <a href="{{ route('petugas.verifikasi.index') }}" class="text-success text-decoration-none small fw-bold">
                        Buka Manajemen Verifikasi <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection