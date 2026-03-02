<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="bi bi-list"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center" data-bs-toggle="dropdown" href="#">
                <span class="me-2 text-dark small fw-bold">{{ Auth::user()->name }}</span>
                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                    <i class="bi bi-person-fill text-white"></i>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow border-0">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i> Keluar Sistem
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>