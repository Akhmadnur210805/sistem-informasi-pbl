<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('mahasiswa.dashboard') }}" class="brand-link">
            <span class="brand-text fw-light">Sistem Informasi PBL</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-house-door-fill"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('mahasiswa.logbook.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.logbook.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-flag-fill"></i>
                        <p>Milestone / Logbook</p>
                    </a>
                </li>
                
                {{-- BAGIAN YANG DIPERBARUI --}}
                <li class="nav-item">
                    <a href="{{ route('mahasiswa.penilaian_sejawat.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.penilaian_sejawat.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Penilaian Sejawat</p>
                    </a>
                </li>
                {{-- MENU BARU: HASIL PENILAIAN --}}
                <li class="nav-item">
                    <a href="{{ route('mahasiswa.nilai.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.nilai.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-journal-check"></i>
                        <p>Transkip</p>
                    </a>
                </li>
                {{-- AKHIR BAGIAN YANG DIPERBARUI --}}

                <li class="nav-item">
                    <a href="{{ route('mahasiswa.ranking.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.ranking.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-bar-chart-line-fill"></i>
                        <p>Ranking</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Log Out</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>