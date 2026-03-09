<nav id="sidebar">
    <div class="p-4 pt-4 text-center border-bottom border-success border-opacity-25 mb-4">
        
        <div class="bg-white p-3 rounded-4 shadow-lg mb-3 mx-auto transition-all logo-container" style="max-width: 150px;">
            <img src="{{ asset('images/BAZNASTALA.png') }}" alt="Logo BAZNAS" class="img-fluid w-100" style="object-fit: contain;">
        </div>
        
        <h4 class="fw-bold mb-0" style="letter-spacing: 1px;">SIMPATIK</h4>
        <p class="small text-white-50 mb-0">BAZNAS Kab. Tanah Laut</p>
    </div>

    <ul class="list-unstyled components px-3 pb-5 mb-5">
        
        <li class="mb-2">
            <p class="text-white-50 small fw-bold text-uppercase tracking-wider px-3 mb-2" style="font-size: 0.75rem; letter-spacing: 1px;">Menu Eksekutif</p>
        </li>
        
        <li class="nav-item mb-2">
            <a href="{{ route('pimpinan.dashboard') }}" class="nav-link text-white px-3 py-2 rounded-3 d-flex align-items-center {{ request()->routeIs('pimpinan.dashboard') ? 'bg-success bg-opacity-25 fw-bold border-start border-4 border-warning' : 'opacity-75 hover-opacity-100' }}">
                <i class="bi bi-grid-1x2-fill me-3 fs-5"></i> Dashboard Utama
            </a>
        </li>

        <li class="mb-2 mt-4">
            <p class="text-white-50 small fw-bold text-uppercase tracking-wider px-3 mb-2" style="font-size: 0.75rem; letter-spacing: 1px;">Monitoring Data</p>
        </li>

        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white px-3 py-2 rounded-3 d-flex align-items-center opacity-75 hover-opacity-100" title="Sedang dalam pengembangan">
                <i class="bi bi-people-fill me-3 fs-5"></i> Data Mustahik
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white px-3 py-2 rounded-3 d-flex align-items-center opacity-75 hover-opacity-100" title="Sedang dalam pengembangan">
                <i class="bi bi-activity me-3 fs-5"></i> Log Aktivitas Petugas
            </a>
        </li>

        <li class="mb-2 mt-4">
            <p class="text-white-50 small fw-bold text-uppercase tracking-wider px-3 mb-2" style="font-size: 0.75rem; letter-spacing: 1px;">Rekapitulasi</p>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('pimpinan.laporan.index') }}" class="nav-link text-white px-3 py-2 rounded-3 d-flex align-items-center {{ request()->routeIs('pimpinan.laporan.*') ? 'bg-success bg-opacity-25 fw-bold border-start border-4 border-warning' : 'opacity-75 hover-opacity-100' }}">
                <i class="bi bi-printer-fill me-3 fs-5"></i> Cetak Laporan PDF
            </a>
        </li>

        <li class="nav-item mb-2 mt-2">
            <a href="#" class="nav-link text-white px-3 py-2 rounded-3 d-flex align-items-center opacity-75 hover-opacity-100">
                <i class="bi bi-gear-fill me-3 fs-5"></i> Pengaturan Akun
            </a>
        </li>
    </ul>

    <div class="position-absolute bottom-0 w-100 p-4 border-top border-success border-opacity-25 text-center" style="background-color: #1e5128;">
        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 w-100 fw-bold shadow-sm d-flex align-items-center justify-content-center">
            <i class="bi bi-star-fill me-2 text-dark"></i> Akses Pimpinan
        </span>
    </div>
</nav>

<style>
    /* Transisi Halus & Efek Geser saat Hover Menu Sidebar */
    .nav-link {
        transition: all 0.2s ease-in-out;
    }
    .nav-link.hover-opacity-100:hover {
        opacity: 1 !important;
        background-color: rgba(255, 255, 255, 0.08);
        transform: translateX(4px); /* Efek menggeser sedikit ke kanan saat disorot */
    }
    
    /* Efek Hover Animasi pada Logo */
    .logo-container {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .logo-container:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2) !important;
    }
    
    /* Memastikan sidebar bisa di-scroll jika menu terlalu banyak, 
       tapi menyembunyikan scrollbar agar tetap elegan */
    #sidebar .list-unstyled {
        height: calc(100vh - 280px);
        overflow-y: auto;
    }
    #sidebar .list-unstyled::-webkit-scrollbar {
        width: 0px;
        background: transparent;
    }
</style>