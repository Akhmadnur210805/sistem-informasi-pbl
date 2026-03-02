<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('petugas.dashboard') }}" class="brand-link">
            <span class="brand-text fw-light">SIMPATIK BAZNAS</span>
        </a>
    </div>
    
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
                
                {{-- 1. Menu Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-house-door-fill"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header mt-2 text-uppercase fs-7 text-secondary">Data Master</li>
                
                {{-- 2. Menu Kelola Kategori Bantuan --}}
                <li class="nav-item">
                    <a href="{{ route('petugas.kategori.index') }}" class="nav-link {{ request()->routeIs('petugas.kategori.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-tags-fill"></i>
                        <p>Kategori Bantuan</p>
                    </a>
                </li>

                {{-- 3. Menu Kelola Data Mustahik --}}
                <li class="nav-item">
                    <a href="{{ route('petugas.mustahik.index') }}" class="nav-link {{ request()->routeIs('petugas.mustahik.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Data Mustahik</p>
                    </a>
                </li>

                <li class="nav-header mt-2 text-uppercase fs-7 text-secondary">Operasional</li>

                {{-- 4. Menu Verifikasi Pengajuan Masuk --}}
                <li class="nav-item">
                    <a href="{{ route('petugas.verifikasi.index') }}" class="nav-link {{ request()->routeIs('petugas.verifikasi.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-file-earmark-check"></i>
                        <p>Verifikasi Pengajuan</p>
                    </a>
                </li>

                {{-- 5. Menu Log Riwayat (Data yang sudah diproses) --}}
                <li class="nav-item">
                    <a href="{{ route('petugas.log.index') }}" class="nav-link {{ request()->routeIs('petugas.log.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-clock-history"></i>
                        <p>Log Riwayat</p>
                    </a>
                </li>

                <li class="nav-header mt-2 border-top border-secondary mx-3"></li>

                {{-- 6. Tombol Logout --}}
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon bi bi-box-arrow-right text-danger"></i>
                        <p class="text-danger">Log Out</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>