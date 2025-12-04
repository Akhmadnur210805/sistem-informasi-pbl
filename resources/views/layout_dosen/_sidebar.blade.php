<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('dosen.dashboard') }}" class="brand-link">
            <span class="brand-text fw-light">Sistem Informasi PBL</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('dosen.dashboard') }}" class="nav-link {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-house-door-fill"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Menu Kelompok PBL --}}
                <li class="nav-item">
                    <a href="{{ route('dosen.kelompok.index') }}" class="nav-link {{ request()->routeIs('dosen.kelompok.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Kelompok PBL</p>
                    </a>
                </li>

                 {{-- Menu Penilaian --}}
                <li class="nav-item">
                    <a href="{{ route('dosen.penilaian.index') }}" class="nav-link {{ request()->routeIs('dosen.penilaian.index', 'dosen.penilaian.form') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-card-checklist"></i>
                        <p>Penilaian</p>
                    </a>
                </li>

                {{-- Menu Ranking --}}
                <li class="nav-item">
                    <a href="{{ route('dosen.ranking.index') }}" class="nav-link {{ request()->routeIs('dosen.ranking.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-bar-chart-line-fill"></i>
                        <p>Ranking</p>
                    </a>
                </li>

                {{-- BAGIAN BARU UNTUK REKAPITULASI --}}
                <li class="nav-header">REKAPITULASI</li>
                <li class="nav-item">
                    <a href="{{ route('dosen.rekap.logbook') }}" class="nav-link {{ request()->routeIs('dosen.rekap.logbook') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-book-half"></i>
                        <p>Rekap Logbook</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dosen.rekap.penilaian_sejawat') }}" class="nav-link {{ request()->routeIs('dosen.rekap.penilaian_sejawat') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-check-fill"></i>
                        <p>Rekap Penilaian Sejawat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dosen.penilaian_kelompok.index') }}" class="nav-link {{ request()->routeIs('dosen.penilaian_kelompok.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-collection-fill"></i>
                        <p>Penilaian Kelompok</p>
                    </a>
                </li>
                {{-- AKHIR BAGIAN BARU --}}

                {{-- Tombol Logout --}}
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