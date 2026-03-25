@extends('layout_pimpinan.app')

@section('content-header')
<div class="mb-4 pt-2">
    <h4 class="fw-bold mb-1" style="color: #1a4321;">Pengaturan Akun</h4>
    <p class="text-muted small">Kelola informasi profil dan keamanan akun Anda.</p>
</div>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 10px;">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- Notifikasi Error Validasi --}}
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
            <div class="d-flex align-items-center mb-1">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <strong class="small">Terjadi kesalahan:</strong>
            </div>
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                    <p class="mb-2"><i class="bi bi-envelope me-2"></i> {{ auth()->user()->email }}</p>
                    <p class="mb-0"><i class="bi bi-calendar-check me-2"></i> Bergabung: {{ auth()->user()->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Sisi Kanan: Form Update --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <form action="{{ route('pimpinan.pengaturan.update') }}" method="POST">
                        @csrf
                        <h6 class="fw-bold mb-4 border-bottom pb-2"><i class="bi bi-shield-lock me-2"></i> Update Keamanan Akun</h6>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Alamat Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" placeholder="Masukkan email aktif" required>
                        </div>

                        <div class="row">
                            {{-- Input Password Baru --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 karakter">
                                    <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('password', 'eye-icon-1')" style="border-color: #dee2e6;">
                                        <i class="bi bi-eye" id="eye-icon-1"></i>
                                    </button>
                                </div>
                            </div>
                            
                            {{-- Input Konfirmasi Password --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                                    <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('password_confirmation', 'eye-icon-2')" style="border-color: #dee2e6;">
                                        <i class="bi bi-eye" id="eye-icon-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 small mt-2" style="background-color: #e7f3ff; color: #0c5460;">
                            <i class="bi bi-info-circle me-2"></i> Biarkan kolom password kosong jika Anda tidak ingin mengubahnya.
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success px-4 py-2 fw-bold shadow-sm" style="border-radius: 8px; background-color: #1a4321; border: none;">
                                <i class="bi bi-check-circle me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Skrip JavaScript untuk Fitur Lihat/Sembunyikan Password --}}
<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);
        
        if (passwordInput.type === 'password') {
            // Ubah tipe ke text (lihat password)
            passwordInput.type = 'text';
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash');
        } else {
            // Ubah tipe kembali ke password (sembunyikan)
            passwordInput.type = 'password';
            eyeIcon.classList.remove('bi-eye-slash');
            eyeIcon.classList.add('bi-eye');
        }
    }
</script>

<style>
    /* Styling agar input group terlihat menyatu */
    .input-group .btn:focus {
        box-shadow: none;
    }
    .form-control:focus {
        border-color: #1a4321;
        box-shadow: 0 0 0 0.25rem rgba(26, 67, 33, 0.1);
    }
</style>
@endsection