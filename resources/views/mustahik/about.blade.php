@extends('layout_mustahik.app')

@section('content-header')
    <div class="row align-items-center mb-4">
        <div class="col-sm-6">
            <h3 class="fw-bold text-success">
                <i class="bi bi-info-circle-fill me-2"></i>Tentang BAZNAS & SIMPATIK
            </h3>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    {{-- Header Hero Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px; background: linear-gradient(135deg, #1e5128 0%, #4e944f 100%); color: white;">
                <div class="card-body p-5 position-relative">
                    <div class="row align-items-center position-relative" style="z-index: 2;">
                        <div class="col-md-8">
                            <h1 class="fw-bold mb-3">Melayani dengan Amanah, Transparan, dan Profesional</h1>
                            <p class="lead opacity-75">SIMPATIK hadir sebagai solusi digital BAZNAS Kabupaten Tanah Laut untuk mempermudah akses bantuan bagi masyarakat yang membutuhkan secara cepat dan tepat.</p>
                        </div>
                        <div class="col-md-4 text-center d-none d-md-block">
                            <i class="bi bi-shield-check" style="font-size: 9rem; opacity: 0.2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Kolom Kiri: Informasi Utama --}}
        <div class="col-lg-8">
            {{-- Penjelasan SIMPATIK --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-success mb-4">
                        <i class="bi bi-cpu-fill me-2"></i>Mengenal Sistem SIMPATIK
                    </h5>
                    <p class="text-muted" style="line-height: 1.8; text-align: justify;">
                        <strong>SIMPATIK</strong> (Sistem Informasi Manajemen Pelayanan Bantuan Terintegrasi) adalah platform resmi yang dikelola oleh BAZNAS Kabupaten Tanah Laut. Sistem ini dirancang untuk memodernisasi proses pengajuan bantuan, sehingga setiap Mustahik dapat mengajukan permohonan secara mandiri, melacak status verifikasi, dan mendapatkan kepastian bantuan tanpa harus bolak-balik ke kantor.
                    </p>
                    
                    <div class="row g-3 mt-3">
                        <div class="col-md-4">
                            <div class="p-3 rounded-4 border-start border-4 border-warning bg-light h-100">
                                <i class="bi bi-lightning-charge-fill text-warning fs-3 mb-2 d-block"></i>
                                <h6 class="fw-bold">Proses Cepat</h6>
                                <p class="small text-muted mb-0">Pengajuan diproses secara digital dan efisien.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-4 border-start border-4 border-primary bg-light h-100">
                                <i class="bi bi-eye-fill text-primary fs-3 mb-2 d-block"></i>
                                <h6 class="fw-bold">Transparan</h6>
                                <p class="small text-muted mb-0">Status pengajuan terpantau secara real-time.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-4 border-start border-4 border-success bg-light h-100">
                                <i class="bi bi-check-circle-fill text-success fs-3 mb-2 d-block"></i>
                                <h6 class="fw-bold">Tepat Sasaran</h6>
                                <p class="small text-muted mb-0">Verifikasi akurat sesuai syariat dan aturan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Visi & Misi --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-success mb-4">
                        <i class="bi bi-trophy-fill me-2"></i>Visi & Misi BAZNAS
                    </h5>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="p-3 rounded-4" style="background-color: #f0fdf4;">
                                <h6 class="fw-bold text-success"><i class="bi bi-stars me-2"></i>Visi</h6>
                                <p class="text-dark mb-0 italic">"Menjadi lembaga utama menyejahterakan umat melalui tata kelola zakat yang unggul dan terpercaya."</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h6 class="fw-bold text-success mb-3"><i class="bi bi-bullseye me-2"></i>Misi Utama</h6>
                            <div class="row small g-2">
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-2 border rounded-3 mb-2">
                                        <i class="bi bi-1-circle-fill text-success me-2"></i> BAZNAS yang kuat dan amanah.
                                    </div>
                                    <div class="d-flex align-items-center p-2 border rounded-3">
                                        <i class="bi bi-2-circle-fill text-success me-2"></i> Pengumpulan ZIS yang optimal.
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-2 border rounded-3 mb-2">
                                        <i class="bi bi-3-circle-fill text-success me-2"></i> Penyaluran bantuan yang merata.
                                    </div>
                                    <div class="d-flex align-items-center p-2 border rounded-3">
                                        <i class="bi bi-4-circle-fill text-success me-2"></i> Digitalisasi pelayanan modern.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Kontak & Lokasi --}}
        <div class="col-lg-4">
            {{-- Kartu Kontak --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold text-dark mb-0">Hubungi Kami</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3 text-success">
                            <i class="bi bi-geo-alt-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 small">Alamat Kantor</h6>
                            <p class="small text-muted mb-0">Jl. Sapta Marga No 6, Pelaihari, Kabupaten Tanah Laut, Kalimantan Selatan, 70811.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3 text-success">
                            <i class="bi bi-whatsapp fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 small">Layanan WhatsApp</h6>
                            <p class="small text-muted mb-0">+62 821-5208-4083</p>
                            <span class="badge bg-light text-success border small">Hanya Chat</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-0">
                        <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3 text-success">
                            <i class="bi bi-envelope-at-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 small">Email Resmi</h6>
                            <p class="small text-muted mb-0">baznastanahlaut@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Jam Operasional --}}
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-success mb-3"><i class="bi bi-clock-history me-2"></i>Jam Operasional</h6>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent border-dashed">
                            <span class="small">Senin - Kamis</span>
                            <span class="badge bg-success bg-opacity-10 text-success fw-bold">09.00 - 16.00 WITA</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                            <span class="small">Jumat</span>
                            <span class="badge bg-success bg-opacity-10 text-success fw-bold">09.00 - 11.30 WITA</span>
                        </div>
                    </div>
                    <div class="mt-4 p-2 rounded-3 bg-danger bg-opacity-10 text-danger text-center small">
                        <i class="bi bi-info-circle-fill me-1"></i> Sabtu, Minggu & Tanggal Merah <strong>Tutup</strong>.
                    </div>
                </div>
            </div>

            {{-- Info Tambahan --}}
            <div class="mt-4 text-center">
                <p class="small text-muted">© {{ date('Y') }} BAZNAS Kabupaten Tanah Laut. <br> Seluruh hak cipta dilindungi.</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Efek halus saat kartu di-hover */
    .card { transition: transform 0.3s ease; }
    .card:hover { transform: translateY(-5px); }
    .border-dashed { border-style: dashed !important; }
</style>
@endsection