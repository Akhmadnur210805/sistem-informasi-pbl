@extends('layout_petugas.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('petugas.verifikasi.index') }}" class="btn btn-white border rounded-circle p-2 me-3 shadow-sm" style="width: 45px; height: 45px; display: inline-flex; justify-content: center; align-items: center;">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>
            <div>
                <h4 class="fw-bold text-dark mb-0">Verifikasi Berkas Mustahik</h4>
                <span class="text-muted">Tinjau profil dan validasi berkas fisik mustahik.</span>
            </div>
        </div>
        <div>
            {{-- Tombol Cetak PDF --}}
            <a href="{{ route('petugas.pengajuan.download', $pengajuan->id) }}" class="btn btn-primary shadow-sm rounded-pill px-4" target="_blank">
                <i class="bi bi-printer-fill me-2"></i> Cetak Profil (CV)
            </a>
        </div>
    </div>

    @php
        // LOGIKA LABEL DINAMIS BERDASARKAN JENIS FORM
        $jenis = $pengajuan->kategoriBantuan->jenis_form ?? 'umum';
        
        $labelFoto = 'Pas Foto';
        $labelKTP = 'Kartu Tanda Penduduk';
        $labelPendukung = 'Dokumen Pendukung';

        if ($jenis == 'pendidikan') {
            $labelFoto = 'Foto Siswa/Mahasiswa';
            $labelKTP = 'KTP Ortu & Siswa';
            $labelPendukung = 'Berkas Pendidikan (PDF)';
        } elseif ($jenis == 'kesehatan') {
            $labelFoto = 'Foto Pasien';
            $labelKTP = 'KTP Suami & Istri';
            $labelPendukung = 'Berkas Medis (PDF)';
        } elseif ($jenis == 'ekonomi') {
            $labelFoto = 'Foto Tempat Usaha';
            $labelKTP = 'KTP Suami & Istri';
            $labelPendukung = 'Proposal Modal & SKU (PDF)';
        } elseif ($jenis == 'dakwah') {
            $labelKTP = 'KTP Penanggung Jawab';
            $labelPendukung = 'Proposal Kegiatan (PDF)';
        } elseif ($jenis == 'kemanusiaan') {
            $labelFoto = 'Foto Diri Pemohon';
            $labelPendukung = 'Berkas Permohonan & Dokumen (PDF)';
        }
    @endphp

    <div class="row g-4">
        {{-- KOLOM KIRI: FOTO & IDENTITAS DASAR --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-4 text-center">
                    
                    {{-- Tampilkan Foto Jika Ada (Program Dakwah disembunyikan otomatis) --}}
                    @if($pengajuan->pas_foto)
                        <div class="mb-4">
                            <span class="badge bg-light text-dark mb-2 border">{{ $labelFoto }}</span><br>
                            <img src="{{ asset('storage/' . $pengajuan->pas_foto) }}" alt="Foto" class="img-fluid rounded-3 shadow-sm" style="max-height: 250px; object-fit: cover;">
                        </div>
                    @else
                        <div class="mb-4 py-5 bg-light rounded-3 border">
                            <i class="bi bi-file-earmark-text text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-2 mb-0">Pengajuan Berbasis Proposal</p>
                        </div>
                    @endif

                    <h4 class="fw-bold mb-1">{{ $pengajuan->nama_lengkap }}</h4>
                    <span class="badge bg-success-soft text-success px-3 py-2 rounded-pill mb-4"><i class="bi bi-tag-fill me-1"></i> {{ $pengajuan->kategoriBantuan->nama_bantuan }}</span>

                    <div class="text-start mt-2">
                        <div class="mb-3 border-bottom pb-2">
                            <small class="text-muted d-block">Nomor Pengajuan</small>
                            <span class="fw-bold text-dark">{{ $pengajuan->nomor_pengajuan }}</span>
                        </div>
                        <div class="mb-3 border-bottom pb-2">
                            <small class="text-muted d-block">Tanggal Masuk</small>
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d F Y H:i') }}</span>
                        </div>
                        
                        {{-- HANYA TAMPIL JIKA BUKAN DEFAULT '-' --}}
                        @if($pengajuan->jenis_kelamin && $pengajuan->jenis_kelamin != '-')
                        <div class="mb-3 border-bottom pb-2">
                            <small class="text-muted d-block">Jenis Kelamin</small>
                            <span class="fw-bold">{{ $pengajuan->jenis_kelamin }}</span>
                        </div>
                        @endif

                        @if($pengajuan->pekerjaan && $pengajuan->pekerjaan != '-')
                        <div class="mb-3 border-bottom pb-2">
                            <small class="text-muted d-block">Pekerjaan</small>
                            <span class="fw-bold">{{ $pengajuan->pekerjaan }}</span>
                        </div>
                        @endif

                        @if($pengajuan->penghasilan_bulanan && $pengajuan->penghasilan_bulanan > 0)
                        <div class="mb-2">
                            <small class="text-muted d-block">Penghasilan Bulanan</small>
                            <span class="fw-bold">Rp {{ number_format($pengajuan->penghasilan_bulanan, 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: DOKUMEN & FORM VERIFIKASI --}}
        <div class="col-lg-8">
            
            {{-- DATA RINCIAN & ALAMAT --}}
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-card-text text-success me-2"></i> Keterangan Pengajuan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-sm-3 text-muted">Alamat Lokasi</div>
                        <div class="col-sm-9 fw-bold">{{ $pengajuan->alamat_ktp }}</div>
                    </div>
                    
                    {{-- Sembunyikan jika tidak ada titik koordinat --}}
                    @if($pengajuan->titik_koordinat)
                    <div class="row mb-3">
                        <div class="col-sm-3 text-muted">Titik Koordinat</div>
                        <div class="col-sm-9 fw-bold">
                            <a href="https://maps.google.com/?q={{ $pengajuan->titik_koordinat }}" target="_blank" class="text-primary text-decoration-none"><i class="bi bi-geo-alt-fill me-1"></i> Buka di Maps</a>
                        </div>
                    </div>
                    @endif

                    <hr>
                    <div class="mb-2 text-muted">Rincian Pengajuan / Nominal / No HP:</div>
                    <div class="p-3 rounded-3" style="background-color: #f8f9fa; border-left: 4px solid #198754;">
                        <span class="fw-bold text-dark" style="line-height: 1.6; font-size: 1.05rem;">{!! nl2br(e($pengajuan->deskripsi_kondisi)) !!}</span>
                    </div>
                </div>
            </div>

            {{-- DOKUMEN TERLAMPIR --}}
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-folder2-open text-success me-2"></i> Berkas Pendukung</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        
                        {{-- KTP --}}
                        @if($pengajuan->file_ktp)
                        <div class="col-md-6 col-lg-4">
                            <div class="p-3 border rounded-3 text-center bg-light h-100 d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <i class="bi bi-person-vcard fs-1 text-secondary mb-2"></i>
                                    <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">{{ $labelKTP }}</h6>
                                </div>
                                <a href="{{ asset('storage/' . $pengajuan->file_ktp) }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill w-100"><i class="bi bi-eye me-1"></i> Lihat KTP</a>
                            </div>
                        </div>
                        @endif

                        {{-- KK --}}
                        @if($pengajuan->file_kk)
                        <div class="col-md-6 col-lg-4">
                            <div class="p-3 border rounded-3 text-center bg-light h-100 d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <i class="bi bi-people fs-1 text-secondary mb-2"></i>
                                    <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">Kartu Keluarga (KK)</h6>
                                </div>
                                <a href="{{ asset('storage/' . $pengajuan->file_kk) }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill w-100"><i class="bi bi-eye me-1"></i> Lihat KK</a>
                            </div>
                        </div>
                        @endif

                        {{-- SKTM --}}
                        @if($pengajuan->file_sktm)
                        <div class="col-md-6 col-lg-4">
                            <div class="p-3 border rounded-3 text-center bg-light h-100 d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <i class="bi bi-file-medical fs-1 text-secondary mb-2"></i>
                                    <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">SKTM Baru</h6>
                                </div>
                                <a href="{{ asset('storage/' . $pengajuan->file_sktm) }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill w-100"><i class="bi bi-eye me-1"></i> Lihat SKTM</a>
                            </div>
                        </div>
                        @endif

                        {{-- BERKAS UTAMA (PDF) --}}
                        @if($pengajuan->file_pendukung)
                        <div class="col-12 mt-3">
                            <div class="p-4 border rounded-3 d-flex align-items-center justify-content-between" style="background-color: #f0fdf4; border-color: #c8e6c9 !important;">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark-pdf-fill fs-1 text-danger me-3"></i>
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1">{{ $labelPendukung }}</h5>
                                        <small class="text-muted">Pastikan mengecek keabsahan dokumen PDF ini.</small>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $pengajuan->file_pendukung) }}" target="_blank" class="btn btn-success rounded-pill px-4 shadow-sm"><i class="bi bi-folder-symlink-fill me-2"></i> Buka Dokumen</a>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

            {{-- FORM EKSEKUSI VERIFIKASI --}}
            <div class="card shadow-sm border-0" style="border-radius: 15px; border-top: 5px solid #198754 !important;">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-check2-square text-success me-2"></i> Form Keputusan Verifikasi</h5>
                    
                    <form action="{{ route('petugas.verifikasi.proses', $pengajuan->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold mb-2">Status Keputusan <span class="text-danger">*</span></label>
                                <select name="status" class="form-select form-select-lg" required>
                                    <option value="">-- Pilih Keputusan --</option>
                                    <option value="disetujui" {{ $pengajuan->status == 'disetujui' ? 'selected' : '' }}>✅ Setujui Pengajuan</option>
                                    <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>❌ Tolak Pengajuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold mb-2">Catatan Verifikator <small class="text-muted">(Opsional)</small></label>
                                <textarea name="catatan" class="form-control" rows="2" placeholder="Berikan catatan jika ditolak atau disetujui..."></textarea>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 fw-bold shadow-sm">
                                <i class="bi bi-save2 me-2"></i> Simpan Hasil Verifikasi
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