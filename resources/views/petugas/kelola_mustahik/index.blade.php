@extends('layout_petugas.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="fw-bold text-success mb-0">Kelola Data Mustahik</h3>
            <p class="text-muted">Manajemen informasi dan riwayat seluruh penerima zakat (Mustahik).</p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="card shadow-sm border-0 bg-success text-white">
                <div class="card-body p-3">
                    <h6 class="mb-0 small">Total Mustahik Terdaftar</h6>
                    <h3 class="mb-0 fw-bold">{{ $mustahiks->count() }} Orang</h3>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white border-bottom py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 fw-bold">Daftar Mustahik</h5>
                </div>
                <div class="col text-end">
                    <form action="{{ route('petugas.mustahik.index') }}" method="GET">
                        <div class="input-group input-group-sm" style="width: 250px; float: right;">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-start-0" 
                                   placeholder="Cari nama atau email..." value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tableMustahik">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 50px;">No</th>
                            <th>Profil Mustahik</th>
                            <th>Email Login</th> {{-- UBAH NAMA KOLOM DI SINI --}}
                            <th class="text-center">Total Pengajuan</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mustahiks as $index => $m)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-box me-3">
                                        {{ strtoupper(substr($m->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $m->name }}</div>
                                        <div class="text-xs text-muted">Dibuat: {{ $m->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{-- HANYA MENAMPILKAN EMAIL SAJA --}}
                                <div class="text-sm text-dark">
                                    <i class="bi bi-envelope-at me-1 text-success"></i> {{ $m->email }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-light text-success border border-success px-3">
                                    {{ $m->pengajuans_count ?? 0 }} Kali
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('petugas.mustahik.show', $m->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Profil">
                                        <i class="bi bi-person-lines-fill"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Akun" 
                                            onclick="confirmDelete('{{ $m->id }}', '{{ $m->name }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    
                                    <form id="delete-form-{{ $m->id }}" action="{{ route('petugas.mustahik.destroy', $m->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-people mb-2 d-block" style="font-size: 3rem;"></i>
                                Belum ada data mustahik terdaftar.
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
    .avatar-box {
        width: 45px; height: 45px;
        background: linear-gradient(135deg, #1e5128, #4e9f3d);
        color: white; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 1.2rem;
        box-shadow: 0 4px 10px rgba(30, 81, 40, 0.2);
    }
    .table thead th {
        font-weight: 600; text-transform: uppercase;
        font-size: 0.75rem; letter-spacing: 0.5px; padding: 15px 10px;
    }
    .table tbody td { padding: 15px 10px; border-bottom: 1px solid #f8f9fa; }
    .btn-group .btn { padding: 5px 10px; }
    .text-xs { font-size: 0.75rem; }
    .text-sm { font-size: 0.875rem; }
    .table-hover tbody tr:hover { background-color: #fcfdfc; transition: 0.3s; }
</style>

<script>
    function confirmDelete(id, name) {
        if(confirm('Apakah Anda yakin ingin menghapus data mustahik "' + name + '"? Semua data pengajuannya juga akan terhapus.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection