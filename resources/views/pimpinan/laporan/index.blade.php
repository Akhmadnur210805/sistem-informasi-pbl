@extends('layout_pimpinan.app')

@section('content-header')
    <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a4321; letter-spacing: -0.5px;">Cetak Laporan</h4>
            <p class="text-muted small mb-0">Filter dan unduh data pengajuan bantuan dalam format PDF.</p>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header bg-white border-bottom p-4 d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-printer fs-5"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-0">Parameter Laporan</h5>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Tampilkan Error jika validasi tanggal salah --}}
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-4 border-0 mb-4">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pimpinan.laporan.cetak') }}" method="POST" target="_blank">
                        @csrf
                        
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Mulai Tanggal</label>
                                <input type="date" name="tanggal_mulai" class="form-control form-control-lg bg-light border-0" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small">Sampai Tanggal</label>
                                <input type="date" name="tanggal_akhir" class="form-control form-control-lg bg-light border-0" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted small">Pilih Program Bantuan</label>
                            <select name="kategori_id" class="form-select form-select-lg bg-light border-0">
                                <option value="semua">-- Semua Program Bantuan --</option>
                                @foreach($kategoriBantuan as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama_bantuan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-semibold text-muted small">Status Pengajuan</label>
                            <select name="status" class="form-select form-select-lg bg-light border-0">
                                <option value="semua">-- Semua Status --</option>
                                <option value="menunggu">Menunggu Verifikasi (Diproses)</option>
                                <option value="disetujui">Telah Disetujui</option>
                                <option value="ditolak">Ditolak / Dibatalkan</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-pdf-fill fs-4 me-2"></i> Generate Laporan PDF
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection