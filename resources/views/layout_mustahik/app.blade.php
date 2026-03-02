<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPATIK BAZNAS | Mustahik</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,600,700&display=fallback">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; }
        .main-sidebar { background-color: #1e5128 !important; }
        .nav-link.active { background-color: #4e944f !important; color: white !important; }
        .brand-link { border-bottom: 1px solid #2d6a3e !important; background-color: #153e1f !important; }
        .main-header { border-bottom: 1px solid #dee2e6; }
        
        /* Perbaikan agar modal tidak tertutup overlay hitam AdminLTE */
        .modal-backdrop { z-index: 1040 !important; }
        .modal { z-index: 1050 !important; }
        
        /* Gaya tambahan untuk scannability */
        .nav-sidebar .nav-link p { margin-left: 5px; }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="bi bi-list"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 mt-1 mr-3">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-success elevation-4">
        <a href="#" class="brand-link text-center">
            <span class="brand-text font-weight-bold">SIMPATIK BAZNAS</span>
        </a>

        <div class="sidebar">
            <nav class="mt-3">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    {{-- Menu Beranda --}}
                    <li class="nav-item">
                        <a href="{{ route('mustahik.dashboard') }}" class="nav-link {{ request()->routeIs('mustahik.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Halaman Utama</p>
                        </a>
                    </li>

                    {{-- Menu Riwayat --}}
                    <li class="nav-item">
                        <a href="{{ route('mustahik.riwayat') }}" class="nav-link {{ request()->routeIs('mustahik.riwayat') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-clock-history"></i>
                            <p>Riwayat Pengajuan</p>
                        </a>
                    </li>

                    {{-- Menu Tentang (Fitur Baru) --}}
                    <li class="nav-item">
                        <a href="{{ route('mustahik.about') }}" class="nav-link {{ request()->routeIs('mustahik.about') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-info-circle"></i>
                            <p>Tentang BAZNAS</p>
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

    <footer class="main-footer text-center small mt-4">
        <strong>&copy; {{ date('Y') }} SIMPATIK BAZNAS Kabupaten Tanah Laut.</strong>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>