<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('pengelola.dashboard') }}" class="brand-link">
            <span class="brand-text fw-light">Sistem Informasi PBL</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('pengelola.dashboard') }}" class="nav-link active">
                        <i class="nav-icon bi bi-house-door-fill"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                {{-- Data Mahasiwa --}}
                <li class="nav-item">
                    <a href="{{ route('pengelola.mahasiswa.index') }}" class="nav-link {{ request()->routeIs('pengelola.mahasiswa.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-fill"></i>
                        <p>Data Mahasiswa</p>
                    </a>
                </li>

                {{-- Data Dosen --}}
                <li class="nav-item">
                    <a href="{{ route('pengelola.dosen.index') }}" class="nav-link {{ request()->routeIs('pengelola.dosen.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-vcard-fill"></i>
                        <p>Data Dosen</p>
                    </a>
                </li>

                {{-- MENU BARU: Rekap Nilai --}}
                <li class="nav-item">
                    <a href="{{ route('pengelola.rekap_nilai.index') }}" class="nav-link {{ request()->routeIs('pengelola.rekap_nilai.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-journal-text"></i>
                        <p>Rekap Nilai</p>
                    </a>
                </li>

                {{-- MENU BARU: Ranking --}}
                <li class="nav-item">
                    <a href="{{ route('pengelola.ranking.index') }}" class="nav-link {{ request()->routeIs('pengelola.ranking.index') ? 'active' : '' }}">
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