@extends('layout_mustahik.app')

@section('content')
<div class="container-fluid pb-5 px-lg-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('mustahik.riwayat') }}" class="btn btn-light rounded-circle shadow-sm me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h3 class="fw-bold text-dark mb-0">Detail Pengajuan</h3>
            <p class="text-muted mb-0 small">Nomor: <span class="text-success fw-bold">{{ $pengajuan->nomor_pengajuan }}</span></p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-body p-4 text-center">
                    {{-- Pas Foto 3x4 hasil inovasi --}}
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $pengajuan->pas_foto) }}" 
                             class="rounded-3 shadow-sm border" 
                             style="width: 120px; height: 160px; object-fit: cover;">
                    </div>
                    
                    <div class="status-box mb-4">
                        @if($pengajuan->status == 'menunggu')
                            <span class="badge bg-warning px-3 py-2 rounded-pill w-100">
                                <i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi
                            </span>
                        @elseif($pengajuan->status == 'disetujui')
                            <span class="badge bg-success px-3 py-2 rounded-pill w-100">
                                <i class="bi bi-check-circle me-1"></i> Pengajuan Disetujui
                            </span>
                        @else
                            <span class="badge bg-danger px-3 py-2 rounded-pill w-100">
                                <i class="bi bi-x-circle me-1"></i> Pengajuan Ditolak
                            </span>
                        @endif
                    </div>

                    <div class="text-start">
                        <div class="mb-3">
                            <label class="small text-muted d-block">Program Bantuan:</label>
                            <span class="fw-bold text-dark">{{ $pengajuan->kategoriBantuan->nama_bantuan }}</span>
                        </div>
                        <div class="mb-0">
                            <label class="small text-muted d-block">Tanggal Pengajuan:</label>
                            <span class="fw-bold text-dark">{{ $pengajuan->created_at->format('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 text-success border-bottom pb-2">Identitas Sesuai KTP</h6>
                    <div class="mb-3">
                        <label class="small text-muted d-block">Nama Lengkap:</label>
                        <span class="fw-bold text-dark">{{ $pengajuan->nama_lengkap }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted d-block">Jenis Kelamin:</label>
                        <span class="fw-bold">{{ $pengajuan->jenis_kelamin }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted d-block">Tempat, Tanggal Lahir:</label>
                        <span class="fw-bold">{{ $pengajuan->tempat_lahir }}, {{ \Carbon\Carbon::parse($pengajuan->tanggal_lahir)->format('d/m/Y') }}</span>
                    </div>
                    <div class="mb-0">
                        <label class="small text-muted d-block">Alamat KTP:</label>
                        <span class="fw-bold small">{{ $pengajuan->alamat_ktp }}</span>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 text-success border-bottom pb-2">Profil & Ekonomi</h6>
                    <div class="mb-3">
                        <label class="small text-muted d-block">Pendidikan Terakhir:</label>
                        <span class="fw-bold">{{ $pengajuan->pendidikan_terakhir }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted d-block">Pekerjaan Saat Ini:</label>
                        <span class="fw-bold">{{ $pengajuan->pekerjaan }}</span>
                    </div>
                    <div class="mb-0">
                        <label class="small text-muted d-block">Penghasilan Bulanan:</label>
                        <span class="fw-bold text-success">Rp {{ number_format($pengajuan->penghasilan_bulanan, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h5 class="fw-bold mb-0 text-success"><i class="bi bi-files me-2"></i>Dokumen Terlampir</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 text-center bg-light">
                                <i class="bi bi-card-heading fs-2 text-muted mb-2 d-block"></i>
                                <p class="small fw-bold mb-2">Kartu Tanda Penduduk</p>
                                <a href="{{ asset('storage/' . $pengajuan->file_ktp) }}" target="_blank" class="btn btn-success btn-sm w-100 rounded-pill">Lihat Berkas</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 text-center bg-light">
                                <i class="bi bi-people fs-2 text-muted mb-2 d-block"></i>
                                <p class="small fw-bold mb-2">Kartu Keluarga</p>
                                <a href="{{ asset('storage/' . $pengajuan->file_kk) }}" target="_blank" class="btn btn-success btn-sm w-100 rounded-pill">Lihat Berkas</a>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4 text-center">
                            <label class="small fw-bold text-muted d-block text-start mb-2">Foto Kondisi Rumah:</label>
                            {{-- Memastikan path file_pendukung benar agar muncul --}}
                            @if($pengajuan->file_pendukung)
                                <img src="{{ asset('storage/' . $pengajuan->file_pendukung) }}" class="img-fluid rounded-4 shadow-sm" style="max-height: 400px; width: 100%; object-fit: cover;">
                            @else
                                <div class="p-5 bg-light rounded-4 text-muted">
                                    <i class="bi bi-image fs-1 d-block mb-2"></i>
                                    Foto rumah tidak tersedia.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-dark">Informasi Tambahan</h5>
                    <div class="mb-4">
                        <label class="small text-muted d-block mb-1">Lokasi Rumah (Maps):</label>
                        @if($pengajuan->titik_koordinat)
                            <a href="{{ $pengajuan->titik_koordinat }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill">
                                <i class="bi bi-geo-alt me-1"></i> Buka Link Google Maps
                            </a>
                        @else
                            <span class="text-muted small italic">Tidak ada link lokasi.</span>
                        @endif
                    </div>
                    <div>
                        <label class="small text-muted d-block mb-1">Deskripsi Kondisi:</label>
                        <div class="p-3 bg-light rounded-3">
                            {{ $pengajuan->deskripsi_kondisi }}
                        </div>
                    </div>
                    
                    {{-- Pesan dari Petugas jika sudah diproses --}}
                    @if($pengajuan->keterangan_petugas)
                        <div class="mt-4 p-3 border-start border-4 border-success bg-success bg-opacity-10 rounded-3">
                            <label class="small text-success fw-bold d-block mb-1">Catatan Petugas:</label>
                            <p class="mb-0 text-dark">{{ $pengajuan->keterangan_petugas }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection