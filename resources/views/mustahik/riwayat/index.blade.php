@extends('layout_mustahik.app')

@section('content')
<div class="container-fluid pb-5">
    <div class="d-flex align-items-center mb-4">
        <div class="bg-success text-white p-3 rounded-4 shadow-sm me-3">
            <i class="bi bi-clock-history fs-3"></i>
        </div>
        <div>
            <h3 class="fw-bold text-dark mb-0">Riwayat Pengajuan</h3>
            <p class="text-muted mb-0">Pantau status bantuan yang telah Anda ajukan melalui sistem SIMPATIK.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-light-warning p-3 me-3 text-warning">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Menunggu</h6>
                        <h4 class="fw-bold mb-0 text-dark">{{ $riwayat->where('status', 'menunggu')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom border-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-success">Daftar Permohonan</h5>
                <span class="badge bg-light text-success px-3 py-2 rounded-pill border border-success border-opacity-25">
                    Total: {{ $riwayat->count() }} Data
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-bold">NOMOR PENGAJUAN</th>
                            <th class="py-3 text-muted fw-bold">KATEGORI BANTUAN</th>
                            <th class="py-3 text-muted fw-bold">TANGGAL</th>
                            <th class="py-3 text-muted fw-bold">STATUS</th>
                            <th class="pe-4 py-3 text-center text-muted fw-bold">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                        <tr class="transition-all">
                            <td class="ps-4">
                                <span class="fw-bold text-dark d-block mb-0">{{ $item->nomor_pengajuan }}</span>
                                <small class="text-muted font-monospace" style="font-size: 0.75rem;">ID: #{{ $item->id }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success bg-opacity-10 p-2 me-2 text-success">
                                        <i class="bi bi-gift-fill" style="font-size: 0.85rem;"></i>
                                    </div>
                                    <span class="fw-semibold text-secondary">{{ $item->kategoriBantuan->nama_bantuan }}</span>
                                </div>
                            </td>
                            <td class="text-secondary">
                                <i class="bi bi-calendar3 me-1 small"></i> {{ $item->created_at->translatedFormat('d F Y') }}
                            </td>
                            <td>
                                @if($item->status == 'menunggu')
                                    <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning px-3 py-2 border border-warning border-opacity-25">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Menunggu Verifikasi
                                    </span>
                                @elseif($item->status == 'disetujui')
                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 border border-success border-opacity-25">
                                        <i class="bi bi-check-circle-fill me-1"></i> Disetujui
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-2 border border-danger border-opacity-25">
                                        <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="pe-4 text-center">
                                {{-- Perbaikan Utama: Menggunakan tag <a> dan route detail --}}
                                <a href="{{ route('mustahik.pengajuan.detail', $item->id) }}" class="btn btn-sm btn-white border rounded-pill shadow-sm px-3 fw-semibold text-success hover-success">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-clipboard-x text-light display-1 mb-3"></i>
                                    <h5 class="text-muted">Belum ada riwayat pengajuan</h5>
                                    <a href="{{ route('mustahik.dashboard') }}" class="btn btn-success rounded-pill px-4 mt-2 shadow-sm">
                                        Mulai Ajukan Sekarang
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
    .bg-light-warning { background-color: #fff9e6; }
    .transition-all:hover { background-color: #f8fcf9; transition: 0.3s; }
    .hover-success:hover { background-color: #198754 !important; color: white !important; }
    .font-monospace { font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace; }
</style>
@endsection