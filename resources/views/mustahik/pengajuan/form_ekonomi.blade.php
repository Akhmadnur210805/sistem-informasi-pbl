@extends('layout_mustahik.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header bg-warning text-dark py-3" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0 fw-bold"><i class="bi bi-shop me-2"></i> Form Pengajuan: {{ $kategori->nama_kategori ?? 'Program Ekonomi' }}</h5>
            <small>Pengajuan bantuan modal usaha kecil, bedah warung, atau alat keterampilan.</small>
        </div>
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('mustahik.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kategori_bantuan_id" value="{{ $kategori->id }}">

                <div class="alert alert-light border-warning border-start border-4 mb-4">
                    <i class="bi bi-info-circle-fill text-warning me-2"></i> Lengkapi data di bawah ini dan pastikan berkas yang diupload sudah sesuai dengan persyaratan BAZNAS.
                </div>

                <h6 class="fw-bold text-warning border-bottom pb-2 mb-3">A. Data Pemohon & Pengajuan</h6>
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold text-dark mb-1">Nama Lengkap Pemohon <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold text-dark mb-1">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 08123456789" required>
                    </div>

                    <div class="col-12">
                        <label class="fw-bold text-dark mb-1">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="alamat_ktp" class="form-control" rows="2" placeholder="Masukkan alamat domisili / alamat tempat usaha..." required>{{ old('alamat_ktp', $user->alamat) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="fw-bold text-dark mb-1">Rincian Biaya / Nominal yang Diajukan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="text" name="nominal_pengajuan" class="form-control border-warning" placeholder="Contoh: 2.500.000" required>
                        </div>
                        <small class="text-muted">Tuliskan nominal angka bantuan modal yang Anda ajukan ke BAZNAS.</small>
                    </div>
                </div>

                <h6 class="fw-bold text-warning border-bottom pb-2 mb-3">B. Berkas Identitas & Foto Usaha</h6>
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold text-dark mb-1">Foto Di Depan Tempat Usaha <span class="text-danger">*</span></label>
                        <input type="file" name="pas_foto" class="form-control border-warning" accept="image/*" required>
                        <small class="text-muted">Pastikan wajah pemohon dan tempat usaha terlihat jelas.</small>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="fw-bold text-dark mb-1">Upload KTP Suami dan Istri <span class="text-danger">*</span></label>
                        <input type="file" name="file_ktp" class="form-control" accept=".jpg,.png,.pdf" required>
                        <small class="text-muted">Gabungkan KTP suami dan istri dalam 1 foto/PDF.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold text-dark mb-1">Upload Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                        <input type="file" name="file_kk" class="form-control" accept=".jpg,.png,.pdf" required>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold text-dark mb-1">Upload SKTM (Asli & Terbaru) <span class="text-danger">*</span></label>
                        <input type="file" name="file_sktm" class="form-control" accept=".jpg,.png,.pdf" required>
                        <small class="text-muted">SKTM dari RT/Lurah/Kades atas nama Kepala Keluarga.</small>
                    </div>
                </div>

                <h6 class="fw-bold text-warning border-bottom pb-2 mb-3 mt-4">C. Berkas Permohonan & Legalitas (Gabungkan jadi 1 PDF)</h6>
                <div class="row g-4 mb-4 bg-light p-3 rounded border-start border-4 border-warning">
                    <div class="col-12">
                        <label class="fw-bold text-dark mb-1">Upload Dokumen Permohonan Modal Usaha <span class="text-danger">*</span></label>
                        <input type="file" name="file_pendukung" class="form-control border-warning" accept=".pdf" required>
                        <div class="mt-2 text-muted small">
                            <strong>Wajib gabungkan file-file berikut menjadi 1 dokumen PDF (Maksimal 10MB):</strong>
                            <ol class="mb-0 mt-1">
                                <li>Surat Permohonan Bantuan ke Ketua BAZNAS Kab. Tala (Ditandatangani Pemohon, RT, Lurah/Kades & Camat).</li>
                                <li>Surat Keterangan Usaha (SKU) atas nama Kepala Keluarga.</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-5 pt-3 border-top">
                    <a href="{{ route('mustahik.dashboard') }}" class="btn btn-light rounded-pill px-4 me-2">Batal</a>
                    <button type="submit" class="btn btn-warning text-dark rounded-pill px-4 fw-bold shadow-sm">
                        <i class="bi bi-send-fill me-2"></i> Ajukan Modal Usaha
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection