@extends('layout_petugas.app')

@section('styles')
<style>
    :root {
        --baznas-green: #1e5128;
        --baznas-light: #4e944f;
    }
    .card-baznas {
        border-radius: 15px;
        border: none;
        border-top: 5px solid var(--baznas-green);
    }
    .btn-baznas {
        background: linear-gradient(45deg, var(--baznas-green), var(--baznas-light));
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        transition: all 0.3s;
    }
    .btn-baznas:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(30, 81, 40, 0.3);
        color: white;
    }
    .form-label {
        color: var(--baznas-green);
        font-weight: 600;
    }
    .form-control:focus {
        border-color: var(--baznas-light);
        box-shadow: 0 0 0 0.25rem rgba(78, 148, 79, 0.25);
    }
</style>
@endsection

@section('content-header')
    <div class="row align-items-center mb-4">
        <div class="col-sm-6">
            <h3 class="fw-bold" style="color: var(--baznas-green);">
                <i class="bi bi-plus-square-dotted me-2"></i>Tambah Kategori
            </h3>
            <p class="text-muted mb-0">Input jenis bantuan baru untuk program pendayagunaan.</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-baznas shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('petugas.kategori.store') }}" method="POST">
                        @csrf
                        <div class="mb-4 text-center">
                            <i class="bi bi-file-earmark-plus fs-1 text-success"></i>
                            <h5 class="mt-2 fw-bold text-dark">Formulir Kategori Bantuan</h5>
                            <hr class="w-25 mx-auto">
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-bookmark-star me-1"></i> Nama Kategori Bantuan</label>
                            <input type="text" class="form-control form-control-lg" name="nama_bantuan" placeholder="Contoh: BAZNAS Sehat" required>
                            <small class="text-muted">Gunakan nama yang jelas untuk memudahkan Mustahik.</small>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-chat-left-text me-1"></i> Deskripsi Program</label>
                            <textarea class="form-control" name="deskripsi" rows="4" placeholder="Jelaskan kriteria dan tujuan bantuan ini..."></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3">
                            <a href="{{ route('petugas.kategori.index') }}" class="btn btn-link text-muted text-decoration-none">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-baznas">
                                <i class="bi bi-save2 me-2"></i> Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection