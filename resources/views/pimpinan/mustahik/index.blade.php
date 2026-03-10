@extends('layout_pimpinan.app')

@section('content-header')
    <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a4321;">Kelola Data Mustahik</h4>
            <p class="text-muted small mb-0">Manajemen informasi dan riwayat seluruh penerima zakat (Mustahik).</p>
        </div>
        
        {{-- Badge Hijau Sesuai Tampilan Admin di Gambar 1 --}}
        <div class="bg-success text-white px-4 py-3 shadow-sm d-flex align-items-center" style="border-radius: 8px; background-color: #1b7a43 !important; min-width: 250px;">
            <div class="ms-auto text-end">
                <small class="d-block opacity-75" style="font-size: 11px; text-transform: uppercase;">Total Mustahik Terdaftar</small>
                {{-- Menggunakan variabel totalMustahik dari controller --}}
                <h3 class="fw-bold mb-0">{{ $totalMustahik ?? 0 }} Orang</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-header bg-white py-3 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Daftar Mustahik</h6>
                
                {{-- Form Pencarian Sesuai Admin --}}
                <form action="{{ route('pimpinan.mustahik.index') }}" method="GET" class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Cari nama atau email..." value="{{ request('search') }}">
                </form>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="bg-light">
                        <tr style="font-size: 11px;" class="text-uppercase fw-bold text-secondary">
                            <th class="ps-4 py-3">NO</th>
                            <th>PROFIL MUSTAHIK</th>
                            <th>EMAIL LOGIN</th>
                            <th class="text-center">PROGRAM BANTUAN</th>
                            <th class="text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataMustahik as $index => $item)
                        <tr>
                            <td class="ps-4 small text-muted">{{ $dataMustahik->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{-- Placeholder Foto Profil seperti Admin --}}
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        <i class="bi bi-person text-secondary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $item->user->name ?? 'User Tidak Ditemukan' }}</div>
                                        <div class="small text-muted" style="font-size: 10px;">NIK: {{ $item->nik ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="small text-muted">{{ $item->user->email ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill px-3 py-2" style="background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0;">
                                    {{ $item->kategoriBantuan->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success px-3 py-2" style="font-size: 10px; border-radius: 4px;">
                                    <i class="bi bi-check-circle-fill me-1"></i> TERVERIFIKASI
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                {{-- Ikon Grup Orang Sesuai Gambar 1 --}}
                                <div class="text-muted opacity-50">
                                    <i class="bi bi-people" style="font-size: 3rem;"></i>
                                    <p class="mt-2 mb-0">Belum ada data mustahik terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Bagian Navigasi Halaman --}}
            @if($dataMustahik->hasPages() || $dataMustahik->total() > 0)
            <div class="px-4 py-3 border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Menampilkan {{ $dataMustahik->firstItem() ?? 0 }} sampai {{ $dataMustahik->lastItem() ?? 0 }} dari {{ $dataMustahik->total() }} data
                    </small>
                    <div class="pagination-sm">
                        {{ $dataMustahik->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Styling agar pagination identik dengan tema hijau BAZNAS */
    .pagination { margin-bottom: 0; gap: 5px; }
    .page-link { color: #1b7a43; border-radius: 5px; border: none; background: #f8f9fa; margin: 0 2px; }
    .page-item.active .page-link { background-color: #1b7a43 !important; border-color: #1b7a43 !important; color: white; }
    .table-hover tbody tr:hover { background-color: #f9fdfa; }
</style>
@endsection