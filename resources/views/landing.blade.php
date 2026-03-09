<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPATIK BAZNAS - Melayani dengan Hati</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-green: #195c2e;
            --secondary-green: #2d8a4e;
            --dark-green: #0a2612; 
            --accent-gold: #ffc107;
            --soft-bg: #f8fafc;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--soft-bg);
            color: #334155;
            overflow-x: hidden;
        }

        /* Navbar Styling */
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(25, 92, 46, 0.95);
            padding: 12px 0;
            transition: all 0.3s;
        }
        
        .navbar-brand img {
            height: 42px; 
            margin-right: 12px;
            filter: brightness(0) invert(1);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            padding: 180px 0 120px;
            color: white;
            border-radius: 0 0 80px 80px;
            position: relative;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 6px;
            background: var(--accent-gold);
            border-radius: 6px 6px 0 0;
        }
        
        .hero-logo {
            max-width: 130px; 
            filter: drop-shadow(0px 10px 15px rgba(0,0,0,0.1));
        }
        
        .hero-logo-wrapper {
            background: white;
            padding: 15px;
            border-radius: 50%;
            width: 160px;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            margin-bottom: 30px;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0px); }
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-top: -60px;
            border-bottom: 4px solid var(--accent-gold);
            transition: transform 0.3s;
        }
        .stat-card:hover { transform: translateY(-5px); }

        /* Tentang BAZNAS */
        .about-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }
        .about-feature {
            background: rgba(25, 92, 46, 0.05);
            border: 1px solid rgba(25, 92, 46, 0.1);
            border-radius: 16px;
            padding: 20px;
            transition: all 0.3s;
        }
        .about-feature:hover {
            background: rgba(25, 92, 46, 0.1);
            transform: translateY(-3px);
        }

        /* Program Cards */
        .card-program {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.05) !important;
            height: 100%;
        }
        .card-program:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(25, 92, 46, 0.08);
            border-color: rgba(25, 92, 46, 0.2) !important;
        }
        .icon-wrapper {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            transition: all 0.3s;
        }

        /* Timeline */
        .timeline-wrapper { position: relative; padding-left: 40px; }
        .timeline-item { position: relative; padding-bottom: 2.5rem; }
        .timeline-item::before {
            content: ''; position: absolute; left: -40px; top: 45px; bottom: -5px;
            width: 2px; background-color: #c8e6c9; 
        }
        .timeline-item:last-child::before { display: none; }
        .timeline-step {
            position: absolute; left: -65px; top: 0; width: 50px; height: 50px;
            background: var(--primary-green); color: white; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 1.2rem; box-shadow: 0 0 0 8px rgba(25, 92, 46, 0.08); z-index: 2;
        }
        .timeline-step.step-final {
            background-color: var(--accent-gold); color: var(--primary-green);
            box-shadow: 0 0 0 8px rgba(255, 193, 7, 0.15);
        }

        /* Buttons */
        .btn-primary-custom {
            background-color: var(--accent-gold); color: var(--primary-green);
            border: none; padding: 12px 35px; border-radius: 12px;
            font-weight: 800; transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            background-color: #e5ad06; transform: scale(1.05); color: var(--primary-green);
        }

        /* Footer */
        footer {
            background-color: var(--dark-green); color: #e2e8f0;
            padding: 80px 0 30px; border-top: 5px solid var(--accent-gold);
        }
        .footer-link { color: #cbd5e1; text-decoration: none; transition: color 0.2s; }
        .footer-link:hover { color: var(--accent-gold); padding-left: 5px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4 d-flex align-items-center" href="#">
            <img src="{{ asset('images/BAZNASTALA.png') }}" alt="Logo">
            <span class="ms-1 tracking-wider">SIMPATIK</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link px-3 fw-medium" href="#tentang">Tentang BAZNAS</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-medium" href="#program">Program Bantuan</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-medium" href="#alur">Alur Pengajuan</a></li>
                <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                    @auth
                        <a href="{{ route('landing') }}" class="btn btn-warning rounded-pill px-4 fw-bold text-dark shadow-sm">
                            <i class="bi bi-grid-fill me-2"></i> Dashboard Saya
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-warning rounded-pill px-4 fw-bold text-dark shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Login Mustahik
                        </a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="hero-section text-center">
    <div class="container">
        <div class="animate__animated animate__fadeInUp d-flex flex-column align-items-center">
            <div class="hero-logo-wrapper">
                <img src="{{ asset('images/BAZNASTALA.png') }}" alt="Logo BAZNAS" class="img-fluid hero-logo">
            </div>
            <span class="badge bg-white text-success px-4 py-2 rounded-pill mb-3 fw-bold shadow-sm" style="letter-spacing: 1px; font-size: 0.8rem;">
                <i class="bi bi-patch-check-fill text-warning me-1"></i> PORTAL RESMI BAZNAS KAB. TANAH LAUT
            </span>
            <h1 class="display-4 fw-bold mb-4" style="line-height: 1.2;">Ubah Zakat Menjadi <br><span class="text-warning">Manfaat Nyata</span></h1>
            <p class="lead opacity-75 mb-5 mx-auto" style="max-width: 750px; font-size: 1.1rem; line-height: 1.6;">
                Platform digital SIMPATIK hadir untuk memudahkan Anda mengajukan permohonan bantuan zakat secara transparan, cepat, dan tepat sasaran demi mewujudkan kemandirian umat.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="#program" class="btn btn-primary-custom shadow-lg">Mulai Ajukan Sekarang</a>
                <a href="#alur" class="btn btn-outline-light border-2 rounded-pill px-4 fw-bold d-flex align-items-center transition-all">
                    <i class="bi bi-play-circle-fill me-2"></i> Pelajari Alur
                </a>
            </div>
        </div>
    </div>
</section>

<div class="container mb-5">
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="stat-card animate__animated animate__fadeInLeft">
                <div class="d-flex justify-content-center mb-2 text-warning fs-1"><i class="bi bi-grid-fill"></i></div>
                <h2 class="fw-bold text-success mb-0">{{ $daftarBantuan->count() ?? '5' }}+</h2>
                <p class="text-muted fw-bold text-uppercase mb-0" style="letter-spacing: 1px; font-size: 0.85rem;">Kategori Program</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card animate__animated animate__fadeInUp">
                <div class="d-flex justify-content-center mb-2 text-warning fs-1"><i class="bi bi-shield-check"></i></div>
                <h2 class="fw-bold text-success mb-0">100%</h2>
                <p class="text-muted fw-bold text-uppercase mb-0" style="letter-spacing: 1px; font-size: 0.85rem;">Penyaluran Transparan</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card animate__animated animate__fadeInRight">
                <div class="d-flex justify-content-center mb-2 text-warning fs-1"><i class="bi bi-clock-history"></i></div>
                <h2 class="fw-bold text-success mb-0">24/7</h2>
                <p class="text-muted fw-bold text-uppercase mb-0" style="letter-spacing: 1px; font-size: 0.85rem;">Akses Digital</p>
            </div>
        </div>
    </div>
</div>

<section class="py-5" id="tentang">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 pe-lg-5">
                <h6 class="text-success fw-bold text-uppercase" style="letter-spacing: 2px;">PROFIL LEMBAGA</h6>
                <h2 class="display-6 fw-bold text-dark mb-4" style="line-height: 1.3;">Mengenal BAZNAS Kabupaten Tanah Laut</h2>
                <div class="bg-warning mb-4" style="width: 70px; height: 4px; border-radius: 2px;"></div>
                
                <p class="text-secondary mb-4 fs-6" style="line-height: 1.8;">
                    Badan Amil Zakat Nasional (BAZNAS) merupakan badan resmi dan satu-satunya yang dibentuk oleh pemerintah berdasarkan Keputusan Presiden RI No. 8 Tahun 2001 yang memiliki tugas dan fungsi menghimpun dan menyalurkan zakat, infaq, dan sedekah (ZIS).
                </p>
                <p class="text-secondary mb-5 fs-6" style="line-height: 1.8;">
                    Kehadiran platform <strong>SIMPATIK</strong> merupakan komitmen BAZNAS Tanah Laut dalam mewujudkan digitalisasi pelayanan publik yang cepat, transparan, dan mudah diakses oleh seluruh lapisan masyarakat.
                </p>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="about-feature h-100">
                            <i class="bi bi-shield-check text-success fs-2 mb-2 d-block"></i>
                            <h6 class="fw-bold text-dark mb-1">Amanah & Syar'i</h6>
                            <p class="text-muted small mb-0">Pengelolaan dana dilakukan sesuai syariat Islam & aturan negara.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="about-feature h-100">
                            <i class="bi bi-graph-up-arrow text-success fs-2 mb-2 d-block"></i>
                            <h6 class="fw-bold text-dark mb-1">Tepat Sasaran</h6>
                            <p class="text-muted small mb-0">Verifikasi ketat memastikan bantuan sampai ke yang berhak.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="about-card text-center">
                    <div class="position-absolute top-0 end-0 bg-warning rounded-circle" style="width: 120px; height: 120px; opacity: 0.15; transform: translate(40px, -40px);"></div>
                    <div class="position-absolute bottom-0 start-0 bg-success rounded-circle" style="width: 150px; height: 150px; opacity: 0.1; transform: translate(-50px, 50px);"></div>
                    
                    <img src="{{ asset('images/BAZNASTALA.png') }}" alt="Logo BAZNAS Besar" class="img-fluid position-relative z-1 mb-4 mt-2" style="max-width: 220px; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.08));">
                    
                    <div class="position-relative z-1">
                        <h4 class="fw-bold text-success mb-1" style="letter-spacing: 1px;">VISI BAZNAS</h4>
                        <p class="text-secondary fw-medium fst-italic mx-auto mb-0" style="max-width: 80%; line-height: 1.6;">
                            "Menjadi lembaga utama menyejahterakan umat."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white" id="program">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-success fw-bold text-uppercase tracking-widest" style="letter-spacing: 2px;">Layanan Kami</h6>
            <h2 class="display-5 fw-bold text-dark">Program Bantuan Aktif</h2>
            <div class="bg-warning mx-auto mt-3" style="width: 80px; height: 5px; border-radius: 3px;"></div>
        </div>

        <div class="row g-4">
            @forelse($daftarBantuan as $bantuan)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-program p-4 d-flex flex-column bg-light">
                        @php
                            $icon = 'bi-collection'; $color = '#195c2e';
                            if($bantuan->jenis_form == 'pendidikan') { $icon = 'bi-mortarboard'; $color = '#198754'; }
                            elseif($bantuan->jenis_form == 'kesehatan') { $icon = 'bi-heart-pulse'; $color = '#dc3545'; }
                            elseif($bantuan->jenis_form == 'ekonomi') { $icon = 'bi-shop-window'; $color = '#fd7e14'; }
                            elseif($bantuan->jenis_form == 'dakwah') { $icon = 'bi-megaphone'; $color = '#0dcaf0'; }
                            elseif($bantuan->jenis_form == 'kemanusiaan') { $icon = 'bi-house-heart'; $color = '#6610f2'; }
                        @endphp

                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="icon-wrapper m-0 bg-white shadow-sm" style="color: {{ $color }}; border: 1px solid {{ $color }}30;">
                                <i class="bi {{ $icon }}"></i>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 fw-medium">
                                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Tersedia
                            </span>
                        </div>
                        
                        <h4 class="fw-bold mb-3 text-dark" style="font-size: 1.2rem;">{{ $bantuan->nama_bantuan }}</h4>
                        
                        <div class="text-secondary mb-4 flex-grow-1" style="font-size: 0.95rem; line-height: 1.6;">
                            {!! nl2br(e($bantuan->deskripsi)) !!}
                        </div>
                        
                        <div class="mt-auto pt-4 border-top">
                            @auth
                                @if(auth()->user()->role == 'mustahik')
                                    <a href="{{ route('mustahik.pengajuan.create', $bantuan->id) }}" class="btn w-100 rounded-pill fw-bold text-white shadow-sm py-2 transition-all" style="background-color: #195c2e;">
                                        Isi Form Sekarang <i class="bi bi-arrow-right-short ms-1 fs-5 align-middle"></i>
                                    </a>
                                @else
                                    <button class="btn btn-white w-100 rounded-pill py-2 text-muted border fw-medium" disabled>Akses Khusus Mustahik</button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn w-100 rounded-pill fw-bold text-white shadow-sm py-2 transition-all" style="background-color: #195c2e;">
                                    Mulai Ajukan <i class="bi bi-arrow-right-short ms-1 fs-5 align-middle"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                        <i class="bi bi-folder-x text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="fw-bold text-dark">Katalog Masih Kosong</h3>
                    <p class="text-muted fs-5">Maaf, saat ini belum ada program bantuan yang dibuka.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="py-5" id="alur" style="background-color: var(--soft-bg);">
    <div class="container py-5">
        <div class="row align-items-center mb-4">
            
            <div class="col-lg-5 mb-5 mb-lg-0 pe-lg-5">
                <h6 class="text-success fw-bold text-uppercase" style="letter-spacing: 1px;">PANDUAN SISTEM</h6>
                <h2 class="display-6 fw-bold mb-4 text-dark">Bagaimana Cara Kerjanya?</h2>
                <p class="text-secondary mb-4 fs-5" style="line-height: 1.8;">Proses pengajuan bantuan di SIMPATIK BAZNAS dirancang sesederhana mungkin agar memudahkan seluruh lapisan masyarakat.</p>
                
                <div class="p-4 rounded-4 bg-white shadow-sm" style="border-left: 5px solid #16a34a;">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-info-circle-fill text-success fs-5 me-2"></i>
                        <h6 class="fw-bold text-success mb-0">Persiapan Dokumen Asli</h6>
                    </div>
                    <p class="text-muted small mb-0" style="line-height: 1.6;">Pastikan Anda telah memfoto/scan KTP, KK, dan Surat Keterangan Tidak Mampu (SKTM) Asli sebelum memulai pengisian form.</p>
                </div>
            </div>
            
            <div class="col-lg-6 offset-lg-1 ps-lg-5">
                <div class="timeline-wrapper ms-4 mt-3 mt-lg-0">
                    <div class="timeline-item">
                        <div class="timeline-step">1</div>
                        <h4 class="fw-bold text-dark mb-2">Buat Akun & Login</h4>
                        <p class="text-secondary" style="line-height: 1.7;">Daftarkan diri Anda sebagai Mustahik menggunakan Alamat Email yang aktif atau langsung masuk secara instan menggunakan Akun Google Anda.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-step">2</div>
                        <h4 class="fw-bold text-dark mb-2">Lengkapi Formulir Digital</h4>
                        <p class="text-secondary" style="line-height: 1.7;">Pilih kategori program bantuan yang paling sesuai dengan kebutuhan Anda, isi data diri, lalu unggah dokumen persyaratan yang diminta sistem.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-step step-final"><i class="bi bi-check-lg"></i></div>
                        <h4 class="fw-bold text-dark mb-2">Tunggu Proses Verifikasi</h4>
                        <p class="text-secondary mb-0" style="line-height: 1.7;">Selesai! Anda tinggal memantau status pengajuan secara *real-time* di halaman Dashboard. Tim BAZNAS akan segera memproses berkas Anda.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mt-5 overflow-hidden border border-success border-opacity-25">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-md-4 p-4 d-flex flex-column justify-content-center align-items-center text-center" style="background-color: #1a4321; color: white;">
                        <i class="bi bi-calendar2-check mb-2 text-warning" style="font-size: 2.5rem;"></i>
                        <h4 class="fw-bold mb-1">Jam Operasional</h4>
                        <p class="mb-0 opacity-75 small">Waktu Pelayanan & Verifikasi</p>
                    </div>
                    
                    <div class="col-md-8 p-4 bg-white d-flex align-items-center">
                        <div class="row w-100 g-3 text-center">
                            
                            <div class="col-sm-4">
                                <div class="p-3 border rounded-3 h-100 d-flex flex-column justify-content-center border-success border-opacity-25 bg-success bg-opacity-10">
                                    <span class="d-block fw-bold text-success mb-2">Senin - Kamis</span>
                                    <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.8rem;">09.00 - 16.00 WITA</span>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="p-3 border rounded-3 h-100 d-flex flex-column justify-content-center border-success border-opacity-25 bg-success bg-opacity-10">
                                    <span class="d-block fw-bold text-success mb-2">Jumat</span>
                                    <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.8rem;">09.00 - 11.30 WITA</span>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="p-3 border rounded-3 border-danger border-opacity-25 bg-danger bg-opacity-10 h-100 d-flex flex-column justify-content-center">
                                    <span class="d-block fw-bold text-danger mb-2">Sabtu & Minggu</span>
                                    <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.8rem;"><i class="bi bi-door-closed-fill me-1"></i> TUTUP</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
</section>

<footer>
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 pe-lg-5">
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ asset('images/BAZNASTALA_putih.png') }}" alt="" style="height: 60px; filter: brightness(0) invert(1);" class="me-3">
                    <div>
                        <h4 class="text-white fw-bold mb-0">SIMPATIK</h4>
                        <span class="text-warning small fw-bold" style="letter-spacing: 1px;">BAZNAS TANAH LAUT</span>
                    </div>
                </div>
                <p style="line-height: 1.8; color: #cbd5e1; font-size: 0.95rem;">Badan Amil Zakat Nasional (BAZNAS) adalah lembaga resmi negara yang berwenang menghimpun dan menyalurkan zakat, infak, dan sedekah demi kesejahteraan umat.</p>
                
                <div class="d-flex gap-3 fs-5 mt-4">
                    <a href="#" class="text-white opacity-50 footer-link"><i class="bi bi-facebook"></i></a>
                    
                    <a href="https://www.instagram.com/baznastala/" target="_blank" rel="noopener noreferrer" class="text-white opacity-50 footer-link">
                        <i class="bi bi-instagram"></i>
                    </a>
                    
                    <a href="#" class="text-white opacity-50 footer-link"><i class="bi bi-youtube"></i></a>
                </div>

            </div>
            
            <div class="col-lg-3 offset-lg-1">
                <h5 class="text-white fw-bold mb-4">Navigasi Cepat</h5>
                <ul class="list-unstyled" style="line-height: 2.2;">
                    <li><a href="#" class="footer-link d-block"><i class="bi bi-chevron-right small text-warning me-1"></i> Beranda</a></li>
                    <li><a href="#tentang" class="footer-link d-block"><i class="bi bi-chevron-right small text-warning me-1"></i> Profil BAZNAS</a></li>
                    <li><a href="#program" class="footer-link d-block"><i class="bi bi-chevron-right small text-warning me-1"></i> Daftar Program</a></li>
                    <li><a href="#alur" class="footer-link d-block"><i class="bi bi-chevron-right small text-warning me-1"></i> Panduan Pengajuan</a></li>
                    <li><a href="{{ route('login') }}" class="footer-link d-block text-warning fw-bold"><i class="bi bi-box-arrow-in-right me-1"></i> Login Mustahik</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3">
                <h5 class="text-white fw-bold mb-4">Pusat Layanan</h5>
                <ul class="list-unstyled" style="line-height: 1.6; color: #cbd5e1;">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-geo-alt-fill text-warning fs-5 me-3 mt-1"></i>
                        <span>Jl. Sapta Marga No 6, Pelaihari, Kabupaten Tanah Laut, Kalimantan Selatan, 70811.</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-telephone-inbound-fill text-warning fs-5 me-3"></i>
                        <span>+62 821-5208-4083</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="bi bi-envelope-at-fill text-warning fs-5 me-3"></i>
                        <span>baznastanahlaut@gmail.com</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <hr class="mt-5 border-secondary opacity-25">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
            <div class="small text-muted mb-2 mb-md-0">
                &copy; {{ date('Y') }} SIMPATIK BAZNAS Kabupaten Tanah Laut.
            </div>
            <div class="small text-muted">
                Dikelola Secara Profesional & Amanah
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>