@extends('layout_petugas.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-warning-soft text-warning rounded-circle mb-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Edit Kategori Bantuan</h4>
                    </div>

                    <form action="{{ route('petugas.kategori.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="fw-bold text-success mb-2"><i class="bi bi-bookmark-fill me-2"></i>Nama Kategori Bantuan</label>
                            <input type="text" name="nama_bantuan" class="form-control" value="{{ $kategori->nama_bantuan }}" required>
                        </div>

                        {{-- DROPDOWN FORM DINAMIS (EDIT) --}}
                        <div class="mb-4">
                            <label class="fw-bold text-success mb-2"><i class="bi bi-ui-checks me-2"></i>Template Form yang Digunakan</label>
                            <select name="jenis_form" class="form-select border-success" required>
                                <option value="umum" {{ $kategori->jenis_form == 'umum' ? 'selected' : '' }}>Form Umum (Standar KTP, KK, SKTM)</option>
                                <option value="pendidikan" {{ $kategori->jenis_form == 'pendidikan' ? 'selected' : '' }}>Form Pendidikan (Ada Upload Raport/SPP)</option>
                                <option value="kesehatan" {{ $kategori->jenis_form == 'kesehatan' ? 'selected' : '' }}>Form Kesehatan (Ada Upload Keterangan Dokter/RS)</option>
                                <option value="dakwah" {{ $kategori->jenis_form == 'dakwah' ? 'selected' : '' }}>Form Dakwah & Advokasi (Hanya KTP & Proposal)</option>
                                <option value="ekonomi" {{ $kategori->jenis_form == 'ekonomi' ? 'selected' : '' }}>Form Ekonomi (Ada Upload Foto Tempat Usaha)</option>
                                <option value="kemanusiaan" {{ $kategori->jenis_form == 'kemanusiaan' ? 'selected' : '' }}>Form Kemanusiaan (Ada Upload Foto Kerusakan)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-success mb-2"><i class="bi bi-chat-left-text-fill me-2"></i>Deskripsi Program</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required>{{ $kategori->deskripsi }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-success mb-2"><i class="bi bi-toggle-on me-2"></i>Status Program</label>
                            <select name="is_active" class="form-select">
                                <option value="1" {{ $kategori->is_active ? 'selected' : '' }}>Aktif (Tersedia)</option>
                                <option value="0" {{ !$kategori->is_active ? 'selected' : '' }}>Tidak Aktif (Ditutup)</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('petugas.kategori.index') }}" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> Batal</a>
                            <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold text-dark">
                                <i class="bi bi-save me-1"></i> Update Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-warning-soft { background-color: #fff8e1; }
</style>
@endsection