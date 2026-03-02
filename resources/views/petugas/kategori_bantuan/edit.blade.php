@extends('layout_petugas.app')

@section('styles')
<style>
    :root {
        --baznas-green: #1e5128;
        --baznas-warning: #ff930f;
    }
    .card-edit {
        border-radius: 15px;
        border: none;
        border-top: 5px solid var(--baznas-warning);
    }
    .btn-update {
        background: linear-gradient(45deg, #ff930f, #ffaa33);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
    }
    .form-label {
        color: var(--baznas-green);
        font-weight: 600;
    }
</style>
@endsection

@section('content-header')
    <div class="row align-items-center mb-4">
        <div class="col-sm-6">
            <h3 class="fw-bold text-dark">
                <i class="bi bi-pencil-square me-2 text-warning"></i>Perbarui Kategori
            </h3>
            <p class="text-muted mb-0">Sesuaikan informasi program bantuan BAZNAS.</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-edit shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('petugas.kategori.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4 text-center">
                            <div class="bg-light d-inline-block p-3 rounded-circle mb-2">
                                <i class="bi bi-arrow-repeat fs-1 text-warning"></i>
                            </div>
                            <h5 class="fw-bold">Ubah Detail Program</h5>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Kategori Bantuan</label>
                            <input type="text" class="form-control" name="nama_bantuan" value="{{ $kategori->nama_bantuan }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3">{{ $kategori->deskripsi }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Status Ketersediaan</label>
                            <div class="row px-2">
                                <div class="col-6 form-check">
                                    <input class="form-check-input" type="radio" name="is_active" id="active" value="1" {{ $kategori->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label text-success fw-bold" for="active">Aktif (Tersedia)</label>
                                </div>
                                <div class="col-6 form-check">
                                    <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0" {{ !$kategori->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger fw-bold" for="inactive">Nonaktif (Ditutup)</label>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('petugas.kategori.index') }}" class="btn btn-light px-4 border">Batal</a>
                            <button type="submit" class="btn btn-update px-4 shadow-sm">
                                <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection