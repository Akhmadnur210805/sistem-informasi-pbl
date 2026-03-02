<aside class="main-sidebar sidebar-dark-success elevation-4" style="background-color: #1e5128;">
    <a href="{{ route('mustahik.dashboard') }}" class="brand-link text-center border-bottom border-secondary">
        <span class="brand-text font-weight-bold text-white">SIMPATIK BAZNAS</span>
    </a>

    <div class="sidebar">
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-header text-uppercase small opacity-50 text-white mb-2">Menu Utama</li>
                
                <li class="nav-item">
                <a href="{{ route('mustahik.dashboard') }}" class="nav-link {{ request()->routeIs('mustahik.dashboard') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-speedometer2"></i>
                    <p>Halaman Utama</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('mustahik.riwayat') }}" class="nav-link {{ request()->routeIs('mustahik.riwayat') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-clock-history"></i>
                    <p>Riwayat Pengajuan</p>
                </a>
            </li>

                <li class="nav-header text-uppercase small opacity-50 text-white mt-3 mb-2">Sistem</li>

                <li class="nav-item">
                    <a href="#" class="nav-link text-warning" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Keluar</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>