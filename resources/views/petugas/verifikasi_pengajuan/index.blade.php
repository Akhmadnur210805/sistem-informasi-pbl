@extends('layout_petugas.app')

@section('content')
<div class="container-fluid pb-5 px-lg-4">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center">
            <div class="header-icon-box shadow-sm me-3">
                <i class="bi bi-shield-check text-white fs-3"></i>
            </div>
            <div>
                <h3 class="fw-bold text-dark mb-0">Antrean Verifikasi</h3>
                <p class="text-muted mb-0 small">Validasi permohonan berdasarkan identitas KTP dan kondisi ekonomi.</p>
            </div>
        </div>
        <div class="date-badge">
            <i class="bi bi-calendar3 me-2 text-success"></i> {{ date('d F Y') }}
        </div>
    </div>

    {{-- Banner Selamat Datang --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-baznas-gradient text-white">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="fw-bold mb-1">Selamat Bertugas, Petugas BAZNAS!</h5>
                    <p class="mb-0 opacity-75">Halaman ini khusus menampilkan data permohonan baru. Pastikan mengecek kesesuaian berkas fisik dengan data digital.</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <i class="bi bi-file-earmark-person display-4 opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Utama --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden main-table-card">
        <div class="card-header bg-white py-3 px-4 border-bottom border-light d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-list-task me-2 text-success"></i>Daftar Tunggu Verifikasi
            </h5>
            <div class="badge-count">
                <span class="fw-bold">{{ $pengajuan->total() }}</span> Permohonan Menunggu
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 border-transparent">
                    <thead class="bg-soft-green text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3 border-0">Profil & Identitas KTP</th>
                            <th class="py-3 border-0">Program Bantuan</th>
                            <th class="py-3 text-center border-0">Status</th>
                            <th class="py-3 text-center border-0">Pekerjaan</th>
                            <th class="pe-4 py-3 text-end border-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $item)
                        <tr class="table-row-hover">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    {{-- Menampilkan Pas Foto atau Inisial --}}
                                    @if($item->pas_foto)
                                        <img src="{{ asset('storage/' . $item->pas_foto) }}" class="rounded-3 me-3" style="width: 45px; height: 55px; object-fit: cover; border: 1px solid #eee;">
                                    @else
                                        <div class="name-avatar me-3">
                                            {{ strtoupper(substr($item->nama_lengkap ?? $item->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <span class="fw-bold text-dark d-block mb-0">{{ $item->nama_lengkap ?? $item->user->name }}</span>
                                        <small class="text-muted small">
                                            <i class="bi bi-geo-alt-fill text-success" style="font-size: 0.7rem;"></i> 
                                            {{ Str::limit($item->alamat_ktp, 30) ?? 'Alamat belum diisi' }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="program-box">
                                    <i class="bi bi-gift text-success me-2"></i>
                                    <span class="text-dark fw-medium">{{ $item->kategoriBantuan->nama_bantuan }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="custom-badge badge-warning">
                                    <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="text-muted small fw-medium">{{ $item->pekerjaan ?? '-' }}</span>
                            </td>
                            <td class="pe-4 text-end">
                                {{-- Tombol Detail Menuju Halaman Verifikasi Lengkap --}}
                                <a href="{{ route('petugas.verifikasi.show', $item->id) }}" class="btn btn-action-detail shadow-sm">
                                    Cek Data Lengkap <i class="bi bi-search ms-1"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state py-4">
                                    <i class="bi bi-check2-circle display-4 text-success mb-3"></i>
                                    <h5 class="text-muted">Semua Antrean Selesai!</h5>
                                    <p class="text-secondary small">Tidak ada permohonan yang perlu diverifikasi saat ini.</p>
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
                {{ $pengajuan->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --soft-green: #f0fdf4;
        --baznas-green: #1e5128;
        --baznas-light: #4e944f;
    }

    .bg-baznas-gradient {
        background: linear-gradient(135deg, var(--baznas-green), var(--baznas-light));
    }

    .header-icon-box {
        background: linear-gradient(135deg, var(--baznas-green), var(--baznas-light));
        width: 50px; height: 50px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 14px;
    }

    .date-badge {
        background: white; padding: 8px 16px; border-radius: 50px;
        font-weight: 600; font-size: 0.85rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .name-avatar {
        width: 45px; height: 45px; background: var(--soft-green);
        color: var(--baznas-green); display: flex; align-items: center;
        justify-content: center; border-radius: 10px; font-weight: 800;
    }

    .program-box {
        background: #f8f9fa; padding: 6px 12px; border-radius: 8px;
        display: inline-flex; align-items: center;
    }

    .custom-badge {
        padding: 6px 14px; border-radius: 50px; font-weight: 700; font-size: 0.75rem;
        display: inline-block;
    }
    .badge-warning { background: #fef9c3; color: #854d0e; border: 1px solid rgba(133, 77, 14, 0.2); }

    .bg-soft-green { background-color: #f8fcf9; }
    .table-row-hover:hover { background-color: var(--soft-green); transition: 0.2s; }

    .btn-action-detail {
        background: var(--baznas-green); color: white; border-radius: 8px;
        font-weight: 600; font-size: 0.85rem; padding: 8px 18px; transition: 0.3s;
        border: none;
    }
    .btn-action-detail:hover { background: var(--baznas-light); color: white; transform: translateY(-2px); }

    .badge-count {
        background: var(--soft-green); color: var(--baznas-green);
        padding: 5px 15px; border-radius: 50px; font-size: 0.85rem;
    }
</style>
@endsection