<aside class="main-sidebar sidebar-dark-success elevation-4" style="background-color: #1e5128;">
    
    {{-- Brand Logo --}}
    <a href="{{ route('pimpinan.dashboard') }}" class="brand-link border-bottom border-success border-opacity-50 d-flex flex-column align-items-center py-4 text-decoration-none">
        <div class="bg-white rounded-circle p-2 mb-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 65px; height: 65px;">
            <img src="{{ asset('images/BAZNASTALA.png') }}" alt="Logo BAZNAS" class="img-fluid" style="object-fit: contain;">
        </div>
        <span class="brand-text font-weight-bold text-white mt-1" style="font-size: 1.1rem; letter-spacing: 1px;">SIMPATIK BAZNAS</span>
    </a>

    <div class="sidebar">
        <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                {{-- Bagian Menu Utama --}}
                <li class="nav-header text-uppercase small opacity-50 text-white mb-2" style="letter-spacing: 1px;">Menu Pimpinan</li>
                
                <li class="nav-item mb-1">
                    <a href="{{ route('pimpinan.dashboard') }}" class="nav-link {{ request()->routeIs('pimpinan.dashboard') ? 'active bg-success' : '' }}">
                        <i class="nav-icon bi bi-grid-1x2-fill"></i>
                        <p>Halaman Utama</p>
                    </a>
                </li>

                {{-- Bagian Monitoring Data Sesuai Gambar Anda --}}
                <li class="nav-header text-uppercase small opacity-50 text-white mt-3 mb-2" style="letter-spacing: 1px;">Monitoring Data</li>

                <li class="nav-item mb-1">
                    <a href="{{ route('pimpinan.mustahik.index') }}" class="nav-link {{ request()->routeIs('pimpinan.mustahik.*') ? 'active bg-success' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Data Mustahik</p>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a href="{{ route('pimpinan.laporan.index') }}" class="nav-link {{ request()->routeIs('pimpinan.laporan.*') ? 'active bg-success' : '' }}">
                        <i class="nav-icon bi bi-file-earmark-pdf-fill"></i>
                        <p>Laporan Pengajuan</p>
                    </a>
                </li>

                {{-- Bagian Sistem --}}
                <li class="nav-header text-uppercase small opacity-50 text-white mt-4 mb-2" style="letter-spacing: 1px;">Sistem</li>

                <li class="nav-item">
                    <a href="#" class="nav-link text-warning border border-warning border-opacity-25 rounded-3 mt-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p class="font-weight-bold">Keluar / Log Out</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>