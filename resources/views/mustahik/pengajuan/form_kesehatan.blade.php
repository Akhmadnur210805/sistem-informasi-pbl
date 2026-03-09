@extends('layout_mustahik.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header bg-danger text-white py-3" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0 fw-bold"><i class="bi bi-heart-pulse-fill me-2"></i> Form Pengajuan: {{ $kategori->nama_kategori ?? 'Program Kesehatan' }}</h5>
            <small>Pengajuan bantuan biaya pengobatan, tunggakan Rumah Sakit, atau kursi roda.</small>
        </div>
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('mustahik.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kategori_bantuan_id" value="{{ $kategori->id }}">

                <div class="alert alert-light border-danger border-start border-4 mb-4">
                    <i class="bi bi-info-circle-fill text-danger me-2"></i> Lengkapi data pemohon dan pastikan berkas medis dari Rumah Sakit sudah disiapkan.
                </div>

                <h6 class="fw-bold text-danger border-bottom pb-2 mb-3">A. Data Pasien & Pengajuan</h6>
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold text-dark mb-1">Nama Lengkap Pasien <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold text-dark mb-1">Nomor WhatsApp / HP (Keluarga) <span class="text-danger">*</span></label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 08123456789" required>
                    </div>

                    <div class="col-12">
                        <label class="fw-bold text-dark mb-1">Alamat Lengkap Sesuai KTP <span class="text-danger">*</span></label>
                        <textarea name="alamat_ktp" class="form-control" rows="2" placeholder="Masukkan alamat lengkap domisili pasien..." required>{{ old('alamat_ktp', $user->alamat) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="fw-bold text-dark mb-1">Rincian Biaya / Nominal yang Diajukan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="text" name="nominal_pengajuan" class="form-control border-danger" placeholder="Contoh: 3.000.000" required>
                        </div>
                        <small class="text-muted">Tuliskan nominal angka bantuan medis yang Anda butuhkan.</small>
                    </div>
                </div>

                <h6 class="fw-bold text-danger border-bottom pb-2 mb-3">B. Berkas Identitas Diri</h6>
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold text-dark mb-1">Foto Pasien Saat Ini <span class="text-danger">*</span></label>
                        <input type="file" name="pas_foto" class="form-control border-danger" accept="image/*" required>
                        <small class="text-muted">Pastikan wajah atau kondisi pasien terlihat jelas.</small>
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

                <h6 class="fw-bold text-danger border-bottom pb-2 mb-3 mt-4">C. Berkas Medis (Gabungkan jadi 1 PDF)</h6>
                <div class="row g-4 mb-4 bg-light p-3 rounded border-start border-4 border-danger">
                    <div class="col-12">
                        <label class="fw-bold text-dark mb-1">Upload Dokumen Permohonan Medis <span class="text-danger">*</span></label>
                        <input type="file" name="file_pendukung" class="form-control border-danger" accept=".pdf" required>
                        <div class="mt-2 text-muted small">
                            <strong>Wajib gabungkan file-file berikut menjadi 1 dokumen PDF (Maksimal 10MB):</strong>
                            <ol class="mb-0 mt-1">
                                <li>Surat Permohonan Bantuan ke Ketua BAZNAS Kab. Tala (Ditandatangani Pemohon, RT, Lurah/Kades & Camat).</li>
                                <li>Surat Keterangan Sakit dari Dokter / Rumah Sakit.</li>
                                <li>Rincian Biaya Pengobatan (RAB) dari Rumah Sakit / Apotek.</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-5 pt-3 border-top">
                    <a href="{{ route('mustahik.dashboard') }}" class="btn btn-light rounded-pill px-4 me-2">Batal</a>
                    <button type="submit" class="btn btn-danger text-white rounded-pill px-4 fw-bold shadow-sm">
                        <i class="bi bi-send-fill me-2"></i> Ajukan Bantuan Medis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection