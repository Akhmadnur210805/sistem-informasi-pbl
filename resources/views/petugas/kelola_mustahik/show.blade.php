@extends('layout_petugas.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('petugas.mustahik.index') }}" class="btn btn-white border shadow-sm me-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <div>
            <h4 class="mb-0 fw-bold text-success">Detail Profil Mustahik</h4>
            <p class="text-muted small mb-0">Informasi lengkap dan histori pengajuan bantuan.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body text-center mt-4">
                    <div class="avatar-box mx-auto mb-3">
                        {{ strtoupper(substr($mustahik->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-1">{{ $mustahik->name }}</h5>
                    <p class="text-muted mb-4">{{ $mustahik->email }}</p>

                    <div class="text-start mt-4 pt-3 border-top">
                        <h6 class="fw-bold text-secondary mb-3">Informasi Kontak & Alamat</h6>
                        <ul class="list-unstyled text-sm">
                            <li class="mb-3">
                                <i class="bi bi-telephone text-success me-2"></i> 
                                <strong>No. HP:</strong> {{ $mustahik->no_hp ?? 'Belum diisi' }}
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-card-text text-success me-2"></i> 
                                <strong>NIK KTP:</strong> {{ $mustahik->nik ?? 'Belum diisi' }}
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-geo-alt text-success me-2"></i> 
                                <strong>Alamat:</strong> {{ $mustahik->alamat ?? 'Belum diisi' }}
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-calendar-check text-success me-2"></i> 
                                <strong>Terdaftar:</strong> {{ $mustahik->created_at->format('d F Y') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">Riwayat Pengajuan Bantuan <span class="badge bg-success ms-2">{{ $mustahik->pengajuans->count() }}</span></h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4 text-xs">TANGGAL</th>
                                    <th class="text-xs">PROGRAM BANTUAN</th>
                                    <th class="text-center text-xs">STATUS AKHIR</th>
                                    <th class="text-center pe-4 text-xs">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mustahik->pengajuans as $pengajuan)
                                <tr>
                                    <td class="ps-4 text-sm text-muted">
                                        <i class="bi bi-calendar-event me-1"></i> {{ $pengajuan->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="text-sm">
                                        <div class="fw-bold text-dark">{{ $pengajuan->kategoriBantuan->nama_kategori ?? 'Umum' }}</div>
                                        <div class="text-xs text-muted">ID: {{ $pengajuan->nomor_pengajuan ?? '-' }}</div>
                                    </td>
                                    <td class="text-center">
                                        @if($pengajuan->status == 'disetujui')
                                            <span class="badge bg-success-soft text-success px-3">Disetujui</span>
                                        @elseif($pengajuan->status == 'ditolak')
                                            <span class="badge bg-danger-soft text-danger px-3">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning-soft text-warning px-3">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <a href="{{ route('petugas.verifikasi.show', $pengajuan->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Berkas Pengajuan">
                                            <i class="bi bi-search"></i> Cek Berkas
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-folder-x mb-2 d-block" style="font-size: 2.5rem;"></i>
                                        Mustahik ini belum pernah mengajukan bantuan apapun.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-box {
        width: 80px; height: 80px;
        background: linear-gradient(135deg, #1e5128, #4e9f3d);
        color: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 2rem;
        box-shadow: 0 4px 10px rgba(30, 81, 40, 0.3);
    }
    .bg-success-soft { background-color: #e8f5e9; }
    .bg-danger-soft { background-color: #ffebee; }
    .bg-warning-soft { background-color: #fff3e0; color: #e65100 !important; }
    .text-xs { font-size: 0.75rem; letter-spacing: 0.5px; }
</style>
@endsection