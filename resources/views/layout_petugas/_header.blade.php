<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                {{-- Rute sudah diubah ke dasbor petugas yang baru --}}
                <a href="{{ route('petugas.dashboard') }}" class="nav-link">Home</a>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <span class="navbar-text fw-bold text-dark">
                    {{-- Kode ini akan otomatis mengambil nama user yang sedang login dari database --}}
                    Selamat datang, {{ Auth::user()->name ?? 'Petugas BAZNAS' }}
                </span>
            </li>
        </ul>
    </div>
</nav>