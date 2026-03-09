@extends('layout_mustahik.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header bg-secondary text-white py-3" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0 fw-bold"><i class="bi bi-file-earmark-text-fill me-2"></i> Form Pengajuan Bantuan BAZNAS</h5>
            <small>Silakan isi data diri Anda dengan lengkap dan benar.</small>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('mustahik.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kategori_bantuan_id" value="{{ $kategori->id }}">

                <h6 class="fw-bold text-secondary border-bottom pb-2 mb-3">A. Data Pribadi & Identitas</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label>Nama Lengkap (Sesuai KTP) <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">Pilih...</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label>Alamat Lengkap (Sesuai KTP) <span class="text-danger">*</span></label>
                        <textarea name="alamat_ktp" class="form-control" rows="2" required></textarea>
                    </div>
                </div>

                <h6 class="fw-bold text-secondary border-bottom pb-2 mb-3">B. Kondisi Ekonomi & Pekerjaan</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label>Pekerjaan Saat Ini <span class="text-danger">*</span></label>
                        <input type="text" name="pekerjaan" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Penghasilan Bulanan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="penghasilan_bulanan" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Jumlah Tanggungan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="jumlah_tanggungan" class="form-control" required>
                            <span class="input-group-text">Orang</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label>Tujuan Mengajukan Bantuan <span class="text-danger">*</span></label>
                        <textarea name="deskripsi_kondisi" class="form-control" rows="3" required></textarea>
                    </div>
                </div>

                <h6 class="fw-bold text-secondary border-bottom pb-2 mb-3">C. Berkas Persyaratan</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label>Pas Foto 3x4 <span class="text-danger">*</span></label>
                        <input type="file" name="pas_foto" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-md-6">
                        <label>Foto KTP <span class="text-danger">*</span></label>
                        <input type="file" name="file_ktp" class="form-control" accept=".jpg,.png,.pdf" required>
                    </div>
                    <div class="col-md-6">
                        <label>Foto Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                        <input type="file" name="file_kk" class="form-control" accept=".jpg,.png,.pdf" required>
                    </div>
                    <div class="col-md-6">
                        <label>Berkas Pendukung Tambahan / SKTM <span class="text-danger">*</span></label>
                        <input type="file" name="file_pendukung" class="form-control" accept=".jpg,.png,.pdf" required>
                    </div>
                    <input type="hidden" name="pendidikan_terakhir" value="-">
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('mustahik.dashboard') }}" class="btn btn-light me-2">Batal</a>
                    <button type="submit" class="btn btn-secondary"><i class="bi bi-send-fill me-1"></i> Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection