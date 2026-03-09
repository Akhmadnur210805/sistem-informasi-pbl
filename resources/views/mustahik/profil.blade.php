@extends('layout_mustahik.app')

@section('title', 'Profil Akun | SIMPATIK')

@section('content')
<div class="container-fluid pb-5">
    <div class="row pt-4">
        <div class="col-md-8 mx-auto">
            
            <div class="d-flex align-items-center mb-4">
                <div class="bg-success rounded-pill me-3" style="width: 6px; height: 24px;"></div>
                <h4 class="fw-bold mb-0 text-dark">Profil Pengguna</h4>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border-top: 5px solid #1e5128;">
                <div class="card-header bg-white border-0 pt-5 pb-0 text-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 90px; height: 90px;">
                        <i class="bi bi-person-fill" style="font-size: 3.5rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-1 text-dark">{{ $user->name ?? 'Pengguna BAZNAS' }}</h4>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill fw-medium">
                        <i class="bi bi-shield-check me-1"></i> Akun Mustahik
                    </span>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <h6 class="fw-bold text-success mb-4 border-bottom border-success border-opacity-25 pb-2">Informasi Detail Akun</h6>
                    
                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted fw-medium"><i class="bi bi-person-vcard me-2"></i>Nama Lengkap</div>
                        <div class="col-sm-8 text-dark fw-bold fs-6">{{ $user->name ?? '-' }}</div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted fw-medium"><i class="bi bi-envelope-at me-2"></i>Alamat Email</div>
                        <div class="col-sm-8 text-dark fw-medium">{{ $user->email ?? '-' }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted fw-medium"><i class="bi bi-activity me-2"></i>Status Akun</div>
                        <div class="col-sm-8">
                            <span class="badge bg-success rounded-3 px-3 py-2 shadow-sm"><i class="bi bi-check-circle-fill me-1"></i> Aktif & Terverifikasi</span>
                        </div>
                    </div>

                    <div class="alert alert-warning border-warning border-opacity-25 bg-warning bg-opacity-10 rounded-4 mt-5 d-flex align-items-center p-3">
                        <i class="bi bi-info-circle-fill text-warning fs-3 me-3"></i>
                        <p class="small text-dark mb-0 fw-medium">
                            Fitur pembaruan profil (Edit Data, Ubah Kata Sandi) saat ini sedang dalam tahap pengembangan oleh Tim IT BAZNAS.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection