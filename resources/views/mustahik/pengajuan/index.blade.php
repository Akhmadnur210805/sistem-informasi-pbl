@extends('layout_mustahik.app')

@section('content')
<div class="container-fluid pb-5">
    <div class="d-flex align-items-center mb-4">
        <div class="bg-success text-white p-3 rounded-3 shadow-sm me-3">
            <i class="bi bi-file-earmark-medical fs-3"></i>
        </div>
        <div>
            <h3 class="fw-bold text-dark mb-0">Form Pengajuan Bantuan</h3>
            <p class="text-muted mb-0">Program: <span class="badge bg-success shadow-sm">{{ $kategori->nama_bantuan }}</span></p>
        </div>
    </div>

    <form action="{{ route('mustahik.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="kategori_bantuan_id" value="{{ $kategori->id }}">

        <div class="row">
            {{-- KOLOM KIRI: DATA PERSONAL & EKONOMI --}}
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h5 class="fw-bold mb-0 text-success"><i class="bi bi-person-badge me-2"></i>Identitas Sesuai KTP</h5>
                    </div>
                    <div class="card-body p-4">
                        {{-- Data Diri Sesuai KTP --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Lengkap (Sesuai KTP)</label>
                            <input type="text" name="nama_lengkap" class="form-control bg-light border-0" value="{{ auth()->user()->name }}" required placeholder="Masukkan nama lengkap sesuai identitas">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select bg-light border-0" required>
                                    <option value="" disabled selected>Pilih Gender</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control bg-light border-0" required placeholder="Kota kelahiran">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control bg-light border-0" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Alamat Lengkap Sesuai KTP</label>
                            <textarea name="alamat_ktp" class="form-control bg-light border-0" rows="3" required placeholder="Jl. Contoh No. 123, RT/RW..."></textarea>
                        </div>

                        <hr class="my-4 opacity-50">

                        <h5 class="fw-bold mb-3 text-success"><i class="bi bi-graph-up-arrow me-2"></i>Profil & Ekonomi</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Pendidikan Terakhir</label>
                                <select name="pendidikan_terakhir" class="form-select bg-light border-0" required>
                                    <option value="" disabled selected>Pilih Pendidikan</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA/SMK">SMA/SMK</option>
                                    <option value="Diploma/Sarjana">Diploma/Sarjana</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Pekerjaan Saat Ini</label>
                                <input type="text" name="pekerjaan" class="form-control bg-light border-0" placeholder="Contoh: Buruh Harian" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Penghasilan Bulanan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">Rp</span>
                                <input type="text" name="penghasilan_bulanan" id="penghasilan" class="form-control bg-light border-0" placeholder="0" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Jumlah Tanggungan</label>
                            <div class="input-group">
                                <input type="number" name="jumlah_tanggungan" class="form-control bg-light border-0" required>
                                <span class="input-group-text bg-light border-0">Orang</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Link Google Maps Rumah (Koordinat)</label>
                            <input type="text" name="titik_koordinat" class="form-control bg-light border-0" placeholder="Paste link lokasi dari Google Maps">
                            <small class="text-muted small">*Sangat membantu petugas saat survei lapangan</small>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold">Deskripsi Kondisi Ekonomi</label>
                            <textarea name="deskripsi_kondisi" class="form-control bg-light border-0" rows="4" required placeholder="Jelaskan secara detail mengapa Anda layak menerima bantuan..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: UNGGUH DOKUMEN --}}
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h5 class="fw-bold mb-0 text-success"><i class="bi bi-cloud-arrow-up me-2"></i>Unggah Dokumen</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info border-0 rounded-3 mb-4" style="background-color: #e8f5e9; color: #1b5e20;">
                            <i class="bi bi-info-circle-fill me-2"></i> Format: JPG/PNG/PDF (Maks. 2MB)
                        </div>

                        <div class="row">
                            {{-- Inovasi: Pas Foto 3x4 --}}
                            <div class="col-md-12 mb-4">
                                <div class="p-3 border rounded-3 text-center bg-light border-dashed">
                                    <label class="form-label fw-bold d-block text-success">Pas Foto Formal (3x4)</label>
                                    <input type="file" name="pas_foto" class="form-control bg-white" required accept="image/*">
                                    <small class="text-muted d-block mt-1">*Foto ini akan digunakan untuk Profil/CV Mustahik</small>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Foto KTP</label>
                                <input type="file" name="file_ktp" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Kartu Keluarga (KK)</label>
                                <input type="file" name="file_kk" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">SKTM (Opsional)</label>
                                <input type="file" name="file_sktm" class="form-control bg-light border-0">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Foto Kondisi Rumah</label>
                                <input type="file" name="file_pendukung" class="form-control bg-light border-0" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0 text-end">
                        <a href="{{ route('mustahik.dashboard') }}" class="btn btn-light px-4 rounded-pill me-2">Batal</a>
                        <button type="submit" class="btn btn-success px-5 rounded-pill fw-bold shadow-sm">Kirim Pengajuan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Format Rupiah Otomatis saat mengetik
    const penghasilan = document.getElementById('penghasilan');
    penghasilan.addEventListener('keyup', function(e) {
        let number_string = this.value.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        this.value = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    });
</script>

<style>
    .border-dashed { border-style: dashed !important; border-width: 2px !important; border-color: #dee2e6 !important; }
    .bg-light { background-color: #f8f9fa !important; }
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border-color: #198754 !important;
    }
</style>
@endsection