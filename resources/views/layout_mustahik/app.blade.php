<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIMPATIK BAZNAS | Mustahik')</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=fallback">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f4f6f9; 
        }
        
        /* ========================================== */
        /* CSS KHUSUS SIDEBAR (Sesuai Gambar Target)  */
        /* ========================================== */
        .main-sidebar { 
            background-color: #1a4f24 !important; /* Hijau gelap seragam */
        }
        
        .brand-link { 
            border-bottom: none !important; /* Hilangkan garis bawah */
        }

        /* Efek Menu Aktif */
        .nav-pills .nav-link.active, 
        .nav-pills .show > .nav-link {
            background-color: #388e3c !important; /* Hijau lebih terang */
            color: white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Efek Hover Menu Tidak Aktif */
        .nav-pills .nav-link:not(.active):hover {
            background-color: rgba(255,255,255,0.08) !important;
            color: white !important;
        }

        /* Penyesuaian Teks & Ikon */
        .nav-sidebar .nav-link p { margin-left: 8px; margin-bottom: 0; }
        .nav-icon { font-size: 1.1rem; }
        /* ========================================== */
        
        /* Perbaikan Z-Index Modal AdminLTE */
        .modal-backdrop { z-index: 1040 !important; }
        .modal { z-index: 1050 !important; }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0 shadow-sm">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="bi bi-list fs-4"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-flex align-items-center pe-3">
                <span class="mr-3 text-muted fw-medium small d-none d-sm-inline-block">
                    <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name ?? 'Mustahik' }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-bold">
                        <i class="bi bi-box-arrow-right me-1"></i> Keluar
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-success elevation-4">
        
        <a href="{{ route('mustahik.dashboard') }}" class="brand-link text-center pt-4 pb-3">
            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2 shadow-sm" style="width: 80px; height: 80px;">
                <img src="{{ asset('images/BAZNASTALA.png') }}" alt="Logo BAZNAS" style="max-height: 50px; object-fit: contain;">
            </div>
            <span class="brand-text fw-bold text-white d-block mt-2" style="font-size: 1.15rem; letter-spacing: 0.5px;">SIMPATIK BAZNAS</span>
        </a>

        <div class="sidebar mt-1">
            <nav class="mt-2 px-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    
                    <li class="nav-header text-uppercase text-white mt-2 mb-2 fw-bold" style="font-size: 0.75rem; letter-spacing: 1.5px; opacity: 0.9;">Menu Utama</li>
                    
                    {{-- Halaman Utama --}}
                    <li class="nav-item mb-2">
                        <a href="{{ route('mustahik.dashboard') }}" class="nav-link py-2 px-3 rounded {{ request()->routeIs('mustahik.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-grid-1x2-fill"></i>
                            <p style="font-size: 1.05rem;">Halaman Utama</p>
                        </a>
                    </li>

                    {{-- Riwayat Pengajuan --}}
                    <li class="nav-item mb-2">
                        <a href="{{ route('mustahik.riwayat') }}" class="nav-link py-2 px-3 rounded {{ request()->routeIs('mustahik.riwayat') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-clock"></i>
                            <p style="font-size: 1.05rem;">Riwayat Pengajuan</p>
                        </a>
                    </li>

                    {{-- Profil Akun --}}
                    <li class="nav-item mb-2">
                        <a href="{{ route('mustahik.profil') }}" class="nav-link py-2 px-3 rounded {{ request()->routeIs('mustahik.profil') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-vcard"></i>
                            <p style="font-size: 1.05rem;">Profil Akun Saya</p>
                        </a>
                    </li>
                    
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper p-4">
        @yield('content-header')
        
        <section class="content">
            @yield('content')
        </section>
    </div>

    <footer class="main-footer text-center small mt-4 border-top">
        <strong>&copy; {{ date('Y') }} SIMPATIK BAZNAS Kabupaten Tanah Laut.</strong> Dikelola Secara Profesional.
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>