@extends('layout_petugas.app')

@section('content')
<div class="container-fluid pb-5 px-lg-4">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center">
            <div class="header-icon-box shadow-sm me-3">
                <i class="bi bi-journal-check text-white fs-3"></i>
            </div>
            <div>
                <h3 class="fw-bold text-dark mb-0">Log Riwayat Pengajuan</h3>
                <p class="text-muted mb-0 small">Daftar seluruh permohonan yang telah selesai diverifikasi (Disetujui/Ditolak).</p>
            </div>
        </div>
        <div class="date-badge">
            <i class="bi bi-clock-history me-2 text-primary"></i> Data Arsip Terkini
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4 filter-glass">
        <div class="card-body p-4">
            <form action="{{ route('petugas.log.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-lg-4 col-md-6">
                    <label class="form-label small fw-bold text-muted mb-2">
                        <i class="bi bi-funnel me-1"></i> Saring Status Akhir
                    </label>
                    <div class="btn-group w-100 custom-filter-group" role="group">
                        <input type="radio" class="btn-check" name="status" id="status_semua" value="" {{ request('status') == '' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="btn btn-filter" for="status_semua">Semua</label>

                        <input type="radio" class="btn-check" name="status" id="status_disetujui" value="disetujui" {{ request('status') == 'disetujui' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="btn btn-filter" for="status_disetujui">Setuju</label>

                        <input type="radio" class="btn-check" name="status" id="status_ditolak" value="ditolak" {{ request('status') == 'ditolak' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="btn btn-filter" for="status_ditolak">Tolak</label>
                    </div>
                </div>

                <div class="col-lg-5 col-md-6">
                    <label class="form-label small fw-bold text-muted mb-2">
                        <i class="bi bi-calendar-range me-1"></i> Periode Waktu
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-2 border-end-0 px-3">
                            <i class="bi bi-calendar3 text-primary"></i>
                        </span>
                        <select name="waktu" class="form-select border-2 border-start-0 py-2 fw-semibold text-dark custom-select" onchange="this.form.submit()">
                            <option value="semua" {{ request('waktu') == 'semua' ? 'selected' : '' }}>Seluruh Riwayat</option>
                            <option value="bulan_ini" {{ request('waktu') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="bulan_lalu" {{ request('waktu') == 'bulan_lalu' ? 'selected' : '' }}>Bulan Sebelumnya</option>
                            <option value="3_bulan" {{ request('waktu') == '3_bulan' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                            <option value="tahun_ini" {{ request('waktu') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3 col-md-12">
                    <a href="{{ route('petugas.log.index') }}" class="btn btn-reset shadow-sm w-100 py-2">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Log
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden main-table-card">
        <div class="card-header bg-white py-3 px-4 border-bottom border-light d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-journal-text me-2 text-primary"></i>Riwayat Permohonan Terproses
            </h5>
            <div class="badge-count">
                Terarsip: <span class="fw-bold">{{ $pengajuan->total() }}</span> Data
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4 py-3">WAKTU MASUK</th>
                            <th>NAMA MUSTAHIK</th>
                            <th>PROGRAM</th>
                            <th class="text-center">STATUS AKHIR</th>
                            <th class="pe-4 text-end">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $item)
                        <tr class="table-row-hover">
                            <td class="ps-4">
                                <div class="text-dark fw-medium small">
                                    <i class="bi bi-calendar2-event me-1 text-muted"></i> {{ $item->created_at->format('d/m/Y') }}
                                </div>
                                <div class="text-muted extra-small">
                                    <i class="bi bi-clock me-1"></i> {{ $item->created_at->format('H:i') }} WIB
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="name-avatar me-3 shadow-sm">
                                        {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-bold text-dark">{{ $item->user->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="program-tag">{{ $item->kategoriBantuan->nama_bantuan }}</span>
                            </td>
                            <td class="text-center">
                                @if($item->status == 'disetujui')
                                    <span class="custom-badge badge-success">Disetujui</span>
                                @elseif($item->status == 'ditolak')
                                    <span class="custom-badge badge-danger">Ditolak</span>
                                @else
                                    <span class="custom-badge badge-warning">Menunggu</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('petugas.verifikasi.show', $item->id) }}" class="btn btn-action-view">
                                    Lihat Berkas <i class="bi bi-search ms-1"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state py-4">
                                    <i class="bi bi-folder-x display-4 text-light mb-3"></i>
                                    <h5 class="text-muted">Tidak ada riwayat ditemukan</h5>
                                    <p class="text-secondary small">Belum ada data yang diproses untuk kriteria saring ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top border-light py-4 px-4">
            <div class="d-flex justify-content-center">
                {{ $pengajuan->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --soft-blue: #f0f7ff;
        --baznas-blue: #0d6efd;
    }

    .header-icon-box {
        background: linear-gradient(135deg, #0d6efd, #0dcaf0);
        width: 50px; height: 50px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 14px;
    }

    .date-badge {
        background: white; padding: 8px 16px; border-radius: 50px;
        font-weight: 600; font-size: 0.85rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .filter-glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }

    .custom-filter-group { background: #f1f3f5; padding: 4px; border-radius: 12px; }
    
    .btn-filter {
        border: none !important; border-radius: 10px !important;
        color: #6c757d; font-weight: 600; font-size: 0.9rem; padding: 8px 12px;
    }

    .btn-check:checked + .btn-filter {
        background: white !important; color: var(--baznas-blue) !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05) !important;
    }

    .btn-reset {
        background: white; border: 2px solid #f1f3f5; border-radius: 10px;
        font-weight: 700; color: #6c757d; transition: 0.3s;
    }
    .btn-reset:hover { background: #f8f9fa; color: #dc3545; }

    .name-avatar {
        width: 35px; height: 35px; background: var(--soft-blue);
        color: var(--baznas-blue); display: flex; align-items: center;
        justify-content: center; border-radius: 8px; font-weight: 800; font-size: 0.8rem;
    }

    .program-tag {
        background: #f8f9fa; padding: 4px 12px; border-radius: 6px;
        font-size: 0.85rem; color: #495057; border: 1px solid #e9ecef;
    }

    .custom-badge {
        padding: 5px 12px; border-radius: 50px; font-weight: 700; font-size: 0.7rem;
    }
    .badge-success { background: #dcfce7; color: #15803d; }
    .badge-danger { background: #fee2e2; color: #b91c1c; }
    .badge-warning { background: #fef9c3; color: #854d0e; }

    .table-row-hover:hover { background-color: var(--soft-blue); transition: 0.2s; }

    .btn-action-view {
        background: transparent; color: var(--baznas-blue); border: 1px solid var(--baznas-blue);
        border-radius: 8px; font-weight: 600; font-size: 0.8rem; padding: 5px 12px; transition: 0.3s;
        text-decoration: none;
    }
    .btn-action-view:hover { background: var(--baznas-blue); color: white; }

    .badge-count {
        background: var(--soft-blue); color: var(--baznas-blue);
        padding: 5px 15px; border-radius: 50px; font-size: 0.85rem;
    }

    .extra-small { font-size: 0.7rem; }
</style>
@endsection