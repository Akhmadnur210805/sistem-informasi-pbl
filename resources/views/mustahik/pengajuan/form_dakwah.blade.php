@extends('layout_mustahik.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header bg-dark text-white py-3" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0 fw-bold"><i class="bi bi-megaphone-fill me-2"></i> Form Pengajuan: {{ $kategori->nama_kategori ?? 'Program Dakwah & Advokasi' }}</h5>
            <small>Pengajuan Proposal Bantuan Kegiatan, Masjid, Guru Ngaji, atau Mualaf.</small>
        </div>
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('mustahik.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kategori_bantuan_id" value="{{ $kategori->id }}">

                <div class="alert alert-light border-dark border-start border-4 mb-4">
                    <i class="bi bi-info-circle-fill text-dark me-2"></i> Lengkapi 4 data utama di bawah ini dan lampirkan proposal kegiatan Anda.
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold text-dark mb-1">Nama Lengkap / Instansi <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->name) }}" placeholder="Contoh: DKM Masjid Al-Huda" required>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold text-dark mb-1">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 08123456789" required>
                    </div>

                    <div class="col-12">
                        <label class="fw-bold text-dark mb-1">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="alamat_ktp" class="form-control" rows="2" placeholder="Masukkan alamat lengkap pengaju atau lokasi masjid/kegiatan..." required>{{ old('alamat_ktp', $user->alamat) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold text-dark mb-1">Upload KTP Penanggung Jawab <span class="text-danger">*</span></label>
                        <input type="file" name="file_ktp" class="form-control border-secondary" accept=".jpg,.png,.pdf" required>
                        <small class="text-muted">Format: PDF/JPG/PNG. Maks 10MB.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold text-dark mb-1">Upload Proposal / Surat Pengantar <span class="text-danger">*</span></label>
                        <input type="file" name="file_pendukung" class="form-control border-dark" accept=".pdf,.doc,.docx" required>
                        <small class="text-muted">Format: PDF/Word. Maks 10MB.</small>
                    </div>
                </div>

                <div class="text-end mt-5 pt-3 border-top">
                    <a href="{{ route('mustahik.dashboard') }}" class="btn btn-light rounded-pill px-4 me-2">Batal</a>
                    <button type="submit" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm">
                        <i class="bi bi-send-fill me-2"></i> Kirim Proposal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection