@extends('layout_pimpinan.app')

@section('content-header')
<div class="mb-4 pt-2">
    <h4 class="fw-bold mb-1" style="color: #1a4321;">Pengaturan Akun</h4>
    <p class="text-muted small">Kelola informasi profil dan keamanan akun Anda.</p>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Sisi Kiri: Informasi Profil --}}
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 15px;">
                <div class="bg-success bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                    <i class="bi bi-person-fill text-success" style="font-size: 50px;"></i>
                </div>
                <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>
                <p class="badge bg-warning text-dark rounded-pill px-3">Akses Pimpinan</p>
                <hr class="my-4 opacity-25">
                <div class="text-start small text-muted">
                    <p class="mb-1"><i class="bi bi-envelope me-2"></i> {{ auth()->user()->email }}</p>
                    <p class="mb-0"><i class="bi bi-calendar-check me-2"></i> Bergabung: {{ auth()->user()->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Sisi Kanan: Form Update --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <form action="#" method="POST"> {{-- Route update bisa ditambahkan nanti --}}
                        @csrf
                        <h6 class="fw-bold mb-4 border-bottom pb-2"><i class="bi bi-shield-lock me-2"></i> Update Keamanan Akun</h6>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Alamat Email</label>
                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" placeholder="Masukkan email aktif">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Password Baru</label>
                                <input type="password" class="form-control" placeholder="Minimal 8 karakter">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" placeholder="Ulangi password baru">
                            </div>
                        </div>

                        <div class="alert alert-info border-0 small mt-2">
                            <i class="bi bi-info-circle me-2"></i> Biarkan kolom password kosong jika Anda tidak ingin mengubahnya.
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="border-radius: 8px;">
                                <i class="bi bi-check-circle me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection