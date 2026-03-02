@extends('layout_petugas.app')

@section('styles')
<style>
    /* Custom Green Theme */
    .bg-baznas {
        background: linear-gradient(45deg, #1e5128, #4e944f);
        color: white;
    }
    .card-baznas {
        border-top: 4px solid #1e5128;
        border-radius: 12px;
        overflow: hidden;
    }
    .btn-baznas {
        background-color: #1e5128;
        border-color: #1e5128;
        color: white;
        transition: all 0.3s;
    }
    .btn-baznas:hover {
        background-color: #4e944f;
        color: white;
        transform: translateY(-2px);
    }
    .badge-aktif {
        background-color: #d1e7dd;
        color: #0f5132;
        border: 1px solid #badbcc;
    }
    .badge-nonaktif {
        background-color: #f8d7da;
        color: #842029;
        border: 1px solid #f5c2c7;
    }
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        color: #555;
    }
</style>
@endsection

@section('content-header')
    <div class="row align-items-center mb-4">
        <div class="col-sm-6">
            <h3 class="fw-bold" style="color: #1e5128;">
                <i class="bi bi-grid-fill me-2"></i>Kelola Kategori Bantuan
            </h3>
            <p class="text-muted mb-0">Manajemen jenis penyaluran zakat, infak, dan sedekah.</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}" class="text-success">Home</a></li>
                <li class="breadcrumb-item active">Kategori Bantuan</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    {{-- Notifikasi Sukses dengan Desain Elegan --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert" style="border-left: 5px solid #1e5128 !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div>
                    <strong>Alhamdulillah!</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-baznas shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="bi bi-table me-2 text-success"></i>Daftar Kategori
                    </h5>
                </div>
                {{-- Fitur Pencarian Tambahan --}}
                <div class="col-md-4">
                    <form action="{{ route('petugas.kategori.index') }}" method="GET">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" class="form-control border-success" placeholder="Cari nama bantuan..." value="{{ request('search') }}">
                            <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('petugas.kategori.create') }}" class="btn btn-baznas px-4 shadow-sm btn-sm">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Kategori Baru
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center py-3" style="width: 70px">No</th>
                            <th>Detail Kategori</th>
                            <th>Deskripsi Program</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 180px">Aksi Strategis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategori as $item)
                            <tr>
                                <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-baznas rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-patch-check"></i>
                                        </div>
                                        <div>
                                            <span class="d-block fw-bold text-dark fs-6">{{ $item->nama_bantuan }}</span>
                                            <small class="text-muted text-uppercase" style="font-size: 0.7rem">ID: #BZN-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 text-muted small" style="max-width: 300px; line-height: 1.5;">
                                        {{ Str::limit($item->deskripsi, 80) ?? 'Tidak ada deskripsi tambahan untuk program ini.' }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    @if($item->is_active)
                                        <span class="badge badge-aktif px-3 py-2 rounded-pill">
                                            <i class="bi bi-check-circle-fill me-1"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-nonaktif px-3 py-2 rounded-pill">
                                            <i class="bi bi-x-circle-fill me-1"></i> Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm rounded">
                                        {{-- Edit --}}
                                        <a href="{{ route('petugas.kategori.edit', $item->id) }}" class="btn btn-light btn-sm px-3 border" title="Ubah Data">
                                            <i class="bi bi-pencil-square text-warning"></i>
                                        </a>

                                        {{-- Hapus --}}
                                        <form action="{{ route('petugas.kategori.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm px-3 border" title="Hapus Data">
                                                <i class="bi bi-trash3-fill text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <img src="https://illustrations.popsy.co/green/waiting-for-notification.svg" style="width: 150px;" class="mb-3">
                                    <h6 class="text-muted fw-light">Data Kategori Bantuan Masih Kosong.</h6>
                                    @if(request('search'))
                                        <p class="small text-muted">Hasil pencarian untuk "{{ request('search') }}" tidak ditemukan.</p>
                                        <a href="{{ route('petugas.kategori.index') }}" class="btn btn-sm btn-link text-success">Reset Pencarian</a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-0 py-3 text-center">
            <small class="text-muted">Menampilkan total <strong>{{ $kategori->count() }}</strong> kategori bantuan terdaftar.</small>
        </div>
    </div>
@endsection