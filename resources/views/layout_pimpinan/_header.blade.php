<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-3 px-4">
    <div class="container-fluid px-0">
        
        <button type="button" id="sidebarCollapse" class="btn btn-light border shadow-sm d-md-none me-3">
            <i class="bi bi-list fs-4"></i>
        </button>

        <span class="fw-bold text-success d-none d-md-inline-block">Pusat Informasi Eksekutif BAZNAS</span>

        <div class="ms-auto d-flex align-items-center">
            
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle p-2 rounded-3 hover-bg-light" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 35px; height: 35px;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
                    </div>
                    <div class="d-none d-sm-block text-end me-2">
                        <span class="d-block fw-bold" style="font-size: 0.9rem; line-height: 1;">{{ Auth::user()->name ?? 'Pimpinan' }}</span>
                        <span class="text-muted" style="font-size: 0.75rem;">Administrator</span>
                    </div>
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="dropdownUser1" style="border-radius: 12px; min-width: 200px;">
                    <li><h6 class="dropdown-header fw-bold text-success">Menu Akun</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger fw-medium py-2 d-flex align-items-center">
                                <i class="bi bi-box-arrow-right me-2 fs-5"></i> Keluar / Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>

<style>
    .hover-bg-light:hover {
        background-color: #f8f9fa;
        transition: 0.3s;
    }
</style>