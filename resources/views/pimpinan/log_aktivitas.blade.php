@extends('layout_pimpinan.app')

@section('content-header')
    <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a4321;">Log Aktivitas Petugas</h4>
            <p class="text-muted small mb-0">Memantau riwayat verifikasi dan aktivitas operasional petugas BAZNAS.</p>
        </div>
        
        {{-- Badge Info --}}
        <div class="bg-primary text-white px-4 py-3 shadow-sm d-flex align-items-center" style="border-radius: 8px; min-width: 250px;">
            <div class="ms-auto text-end">
                <small class="d-block opacity-75" style="font-size: 11px; text-transform: uppercase;">Total Aktivitas Tercatat</small>
                <h3 class="fw-bold mb-0">{{ $logs->total() }} Log</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-header bg-white py-3 px-4">
            <h6 class="fw-bold mb-0">Riwayat Aktivitas Terkini</h6>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="bg-light">
                        <tr style="font-size: 11px;" class="text-uppercase fw-bold text-secondary">
                            <th class="ps-4 py-3">WAKTU</th>
                            <th>PETUGAS</th>
                            <th>MUSTAHIK</th>
                            <th>AKSI / AKTIVITAS</th>
                            <th class="text-center">STATUS AKHIR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="ps-4 small">
                                <div class="text-dark fw-bold">{{ $log->updated_at->format('d/m/Y') }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ $log->updated_at->format('H:i') }} WIB</div>
                            </td>
                            <td>
                                <div class="small fw-bold text-success">
                                    <i class="bi bi-person-badge me-1"></i> Admin BAZNAS
                                </div>
                            </td>
                            <td>
                                <div class="small fw-bold text-dark">{{ $log->user->name ?? 'N/A' }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ $log->kategoriBantuan->nama_kategori ?? '-' }}</div>
                            </td>
                            <td>
                                <span class="small text-muted">Melakukan Verifikasi Data Pengajuan</span>
                            </td>
                            <td class="text-center">
                                @if($log->status == 'disetujui')
                                    <span class="badge bg-success opacity-75" style="font-size: 9px;">DISETUJUI</span>
                                @else
                                    <span class="badge bg-danger opacity-75" style="font-size: 9px;">DITOLAK</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-activity fs-1 d-block mb-2 opacity-25"></i>
                                Belum ada log aktivitas petugas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-4 py-3 border-top">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection