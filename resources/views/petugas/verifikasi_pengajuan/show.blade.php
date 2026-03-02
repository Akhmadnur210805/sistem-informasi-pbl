@extends('layout_petugas.app')

@section('content')
<div class="container-fluid pb-5 px-lg-4">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center">
            <a href="{{ route('petugas.verifikasi.index') }}" class="btn btn-outline-secondary rounded-circle shadow-sm me-3 bg-white">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h3 class="fw-bold text-dark mb-0">Verifikasi Berkas Mustahik</h3>
                <p class="text-muted mb-0 small">Tinjau profil dan validasi berkas fisik mustahik.</p>
            </div>
        </div>
        <a href="{{ route('petugas.pengajuan.download', $pengajuan->id) }}" class="btn btn-primary shadow-sm rounded-pill px-4 fw-bold">
            <i class="bi bi-file-earmark-pdf me-2"></i>Cetak Profil (CV)
        </a>
    </div>

    <div class="row g-4">
        {{-- KOLOM KIRI: PROFIL & DATA IDENTITAS --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="bg-baznas-gradient" style="height: 100px;"></div>
                <div class="card-body pt-0 text-center">
                    <img src="{{ asset('storage/' . $pengajuan->pas_foto) }}" 
                         class="rounded-3 shadow border border-white border-4 bg-white" 
                         style="width: 120px; height: 160px; object-fit: cover; margin-top: -60px;">
                    
                    <h4 class="fw-bold mt-3 mb-1 text-dark">{{ $pengajuan->nama_lengkap ?? $pengajuan->user->name }}</h4>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                        <i class="bi bi-tag-fill me-1"></i> {{ $pengajuan->kategoriBantuan->nama_bantuan }}
                    </span>

                    <ul class="list-group list-group-flush text-start mt-4 border-top">
                        <li class="list-group-item border-0 px-0 py-3">
                            <label class="text-muted small d-block mb-1">NIK</label>
                            <span class="fw-bold">{{ $pengajuan->user->nik ?? 'Belum Terdata' }}</span>
                        </li>
                        <li class="list-group-item border-0 px-0 py-3">
                            <label class="text-muted small d-block mb-1">Jenis Kelamin</label>
                            <span class="fw-bold text-dark">{{ $pengajuan->jenis_kelamin }}</span>
                        </li>
                        <li class="list-group-item border-0 px-0 py-3">
                            <label class="text-muted small d-block mb-1">Tempat, Tanggal Lahir</label>
                            <span class="fw-bold small">{{ $pengajuan->tempat_lahir }}, {{ \Carbon\Carbon::parse($pengajuan->tanggal_lahir)->format('d F Y') }}</span>
                        </li>
                        <li class="list-group-item border-0 px-0 py-3">
                            <label class="text-muted small d-block mb-1">Alamat Lengkap (KTP)</label>
                            <span class="fw-medium text-secondary small" style="line-height: 1.4;">{{ $pengajuan->alamat_ktp }}</span>
                        </li>
                    </ul>
                    
                    @if($pengajuan->titik_koordinat)
                        <a href="{{ $pengajuan->titik_koordinat }}" target="_blank" class="btn btn-outline-primary w-100 rounded-pill mt-3 mb-2">
                            <i class="bi bi-geo-alt-fill me-1"></i> Buka Google Maps
                        </a>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-soft-green">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-success mb-3">RINGKASAN EKONOMI</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Pekerjaan:</span>
                        <span class="fw-bold small">{{ $pengajuan->pekerjaan }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Pendidikan:</span>
                        <span class="fw-bold small">{{ $pengajuan->pendidikan_terakhir }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Penghasilan:</span>
                        <span class="fw-bold text-success">Rp {{ number_format($pengajuan->penghasilan_bulanan, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: BERKAS & FORM VERIFIKASI --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-check me-2 text-success"></i>Berkas Pendukung</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="doc-card p-3 border rounded-4 text-center bg-light">
                                <i class="bi bi-card-heading fs-1 text-muted mb-2 d-block"></i>
                                <h6 class="fw-bold mb-3 small">Kartu Tanda Penduduk</h6>
                                <a href="{{ asset('storage/' . $pengajuan->file_ktp) }}" target="_blank" class="btn btn-success btn-sm px-4 rounded-pill">
                                    <i class="bi bi-eye me-1"></i> Lihat KTP
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="doc-card p-3 border rounded-4 text-center bg-light">
                                <i class="bi bi-people-fill fs-1 text-muted mb-2 d-block"></i>
                                <h6 class="fw-bold mb-3 small">Kartu Keluarga</h6>
                                <a href="{{ asset('storage/' . $pengajuan->file_kk) }}" target="_blank" class="btn btn-success btn-sm px-4 rounded-pill">
                                    <i class="bi bi-eye me-1"></i> Lihat KK
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h6 class="fw-bold text-dark mb-3">Foto Kondisi Rumah</h6>
                            <div class="position-relative overflow-hidden rounded-4 shadow-sm" style="max-height: 450px;">
                                @if($pengajuan->file_pendukung)
                                    <img src="{{ asset('storage/' . $pengajuan->file_pendukung) }}" class="w-100 img-fluid" style="object-fit: cover;">
                                @else
                                    <div class="p-5 text-center bg-light text-muted">Foto rumah tidak tersedia</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FORM KEPUTUSAN VERIFIKASI (Telah Diaktifkan) --}}
            <div class="card border-0 shadow-sm rounded-4 border-start border-5 border-success">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-dark">Keputusan & Catatan Verifikasi</h5>
                    
                    {{-- Form mengarah ke rute proses dengan metode POST --}}
                    <form action="{{ route('petugas.verifikasi.proses', $pengajuan->id) }}" method="POST">
                        @csrf {{-- Token keamanan wajib ada --}}
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Tulis Alasan atau Catatan untuk Mustahik</label>
                            {{-- Field keterangan_petugas sesuai validasi di Controller --}}
                            <textarea name="keterangan_petugas" class="form-control bg-light border-0 @error('keterangan_petugas') is-invalid @enderror" rows="4" required placeholder="Jelaskan alasan persetujuan atau penolakan bantuan ini...">{{ old('keterangan_petugas') }}</textarea>
                            @error('keterangan_petugas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-3">
                            {{-- Tombol 'disetujui' mengirimkan value ke kolom status --}}
                            <button type="submit" name="status" value="disetujui" class="btn btn-success px-5 py-3 fw-bold rounded-pill shadow-sm flex-grow-1">
                                <i class="bi bi-check-circle-fill me-2"></i> Setujui Bantuan
                            </button>
                            {{-- Tombol 'ditolak' mengirimkan value ke kolom status --}}
                            <button type="submit" name="status" value="ditolak" class="btn btn-danger px-5 py-3 fw-bold rounded-pill shadow-sm flex-grow-1">
                                <i class="bi bi-x-circle-fill me-2"></i> Tolak Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-baznas-gradient { background: linear-gradient(135deg, #1e5128 0%, #4e944f 100%); }
    .bg-soft-green { background-color: #f0fdf4; }
    .doc-card { transition: 0.3s; border: 1px dashed #dee2e6 !important; }
    .doc-card:hover { transform: translateY(-5px); border-color: #1e5128 !important; background: #fff !important; }
    .list-group-item { background: transparent; padding-left: 0; padding-right: 0; }
    .form-control:focus { box-shadow: none; background-color: #fff !important; border: 1px solid #1e5128 !important; }
</style>
@endsection