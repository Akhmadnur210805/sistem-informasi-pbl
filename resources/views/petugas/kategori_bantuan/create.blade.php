@extends('layout_petugas.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success-soft text-success rounded-circle mb-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                            <i class="bi bi-plus-square"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Formulir Kategori Bantuan</h4>
                    </div>

                    <form action="{{ route('petugas.kategori.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="fw-bold text-success mb-2"><i class="bi bi-bookmark-fill me-2"></i>Nama Kategori Bantuan</label>
                            <input type="text" name="nama_bantuan" class="form-control" placeholder="Contoh: Program Ekonomi" required>
                            <small class="text-muted">Gunakan nama yang jelas untuk memudahkan Mustahik.</small>
                        </div>

                        {{-- INI ADALAH FITUR BARU DROPDOWN FORM DINAMIS --}}
                        <div class="mb-4">
                            <label class="fw-bold text-success mb-2"><i class="bi bi-ui-checks me-2"></i>Template Form yang Digunakan</label>
                            <select name="jenis_form" class="form-select border-success" required>
                                <option value="">-- Pilih Template Form --</option>
                                <option value="umum">Form Umum (Standar KTP, KK, SKTM)</option>
                                <option value="pendidikan">Form Pendidikan (Ada Upload Raport/SPP)</option>
                                <option value="kesehatan">Form Kesehatan (Ada Upload Keterangan Dokter/RS)</option>
                                <option value="dakwah">Form Dakwah & Advokasi (Hanya KTP & Proposal Kegiatan)</option>
                                <option value="ekonomi">Form Ekonomi (Ada Upload Foto Tempat Usaha/Modal)</option>
                                <option value="kemanusiaan">Form Kemanusiaan (Ada Upload Foto Kerusakan/Bencana)</option>
                            </select>
                            <small class="text-muted">Pilih form mana yang akan ditampilkan kepada Mustahik saat memilih program ini.</small>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-success mb-2"><i class="bi bi-chat-left-text-fill me-2"></i>Deskripsi Program</label>
                            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan kriteria dan tujuan bantuan ini..." required></textarea>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('petugas.kategori.index') }}" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                            <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                                <i class="bi bi-save me-1"></i> Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: #e8f5e9; }
</style>
@endsection