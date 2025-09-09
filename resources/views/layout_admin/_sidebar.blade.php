<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <span class="brand-text fw-light">Sistem Informasi PBL</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
                
                {{-- Menu Dashboard --}}
                <li class="nav-item">
                    {{-- Menambahkan logika untuk class 'active' --}}
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-house-door-fill"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                {{-- Menu Data Mahasiswa --}}
                <li class="nav-item">
                <a href="{{ route('admin.mahasiswa.index') }}" class="nav-link {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-person-fill"></i>
                <p>Data Mahasiswa</p>
                </a>
                </li>

                {{-- Menu Data Dosen --}}
                <li class="nav-item">
                {{-- Perbarui href dan tambahkan logika class 'active' --}}
                <a href="{{ route('admin.dosen.index') }}" class="nav-link {{ request()->routeIs('admin.dosen.index') ? 'active' : '' }}">
                <i class="nav-icon bi bi-person-vcard-fill"></i>
                <p>Data Dosen</p>
                </a>
                </li>

                {{-- MENU BARU: Data Pengelola --}}
                <li class="nav-item">
                    <a href="{{ route('admin.pengelola.index') }}" class="nav-link {{ request()->routeIs('admin.pengelola.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-gear"></i>
                        <p>Data Pengelola</p>
                    </a>
                </li>
                
                {{-- Menu Data Mata Kuliah --}}
                <li class="nav-item">
                <a href="{{ route('admin.matakuliah.index') }}" class="nav-link {{ request()->routeIs('admin.matakuliah.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-book-fill"></i>
                <p>Data Mata Kuliah</p>
                </a>
                </li>
                
                {{-- Menu Data Kelompok --}}
                <li class="nav-item">
                <a href="{{ route('admin.kelompok.index') }}" class="nav-link {{ request()->routeIs('admin.kelompok.index') ? 'active' : '' }}">
                <i class="nav-icon bi bi-people-fill"></i>
                <p>Data Kelompok</p>
                </a>
                </li>

                {{-- Menu Ranking --}}
                <li class="nav-item">
                <a href="{{ route('admin.ranking.index') }}" class="nav-link {{ request()->routeIs('admin.ranking.index') ? 'active' : '' }}">
                <i class="nav-icon bi bi-bar-chart-line-fill"></i>
                <p>Ranking</p>
                </a>
                </li>

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