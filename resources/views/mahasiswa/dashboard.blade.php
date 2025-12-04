@extends('layout_mahasiswa.app')

@section('styles')
<style>
    /* Styling Khusus Dashboard */
    .welcome-card {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
        border: none;
        border-radius: 15px;
    }
    .stat-card {
        border-radius: 15px;
        border: none;
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .calendar-date {
        font-size: 4rem;
        font-weight: bold;
        line-height: 1;
        color: #0d6efd;
    }
    .calendar-month {
        font-size: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    .deadline-item {
        border-left: 4px solid #ffc107;
        background-color: #fff3cd;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 4px;
    }
    .timeline-item {
        padding-left: 20px;
        border-left: 2px solid #e9ecef;
        position: relative;
        margin-bottom: 20px;
    }
    .timeline-item::before {
        content: '';
        width: 12px;
        height: 12px;
        background: #0d6efd;
        border-radius: 50%;
        position: absolute;
        left: -7px;
        top: 5px;
    }
</style>
@endsection

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h3 class="mb-0 fw-bold text-dark">Dashboard Mahasiswa</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    
    {{-- 1. WELCOME BANNER --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card welcome-card shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold">Halo, {{ $user->name }}! 👋</h2>
                            <p class="lead mb-0 opacity-75">
                                Semangat mengerjakan PBL! Jangan lupa mengisi Logbook minggu ini.
                                <br>Kelompok Anda: <strong>{{ $user->kelompok ?? 'Belum ada' }}</strong> (Kelas {{ $user->kelas ?? '-' }})
                            </p>
                        </div>
                        <div class="col-md-4 text-end d-none d-md-block">
                            <i class="bi bi-mortarboard-fill" style="font-size: 5rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. STATISTIK CEPAT --}}
    <div class="row mb-4">
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card stat-card bg-white shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-journal-text text-primary fs-3"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-0">Logbook Terkumpul</h5>
                        <h2 class="fw-bold mb-0">{{ $totalLogbook }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card stat-card bg-white shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-clipboard-check text-success fs-3"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-0">Matkul Dinilai</h5>
                        <h2 class="fw-bold mb-0">{{ $totalMatkulDinilai }} <small class="fs-6 text-muted">/ 4</small></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 mb-3">
            <div class="card stat-card bg-white shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-trophy text-warning fs-3"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-0">Rata-rata Sementara</h5>
                        <h2 class="fw-bold mb-0">{{ number_format($nilaiSementara, 1) }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. MAIN CONTENT AREA --}}
    <div class="row">
        {{-- KOLOM KIRI: Kalender & Deadline --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm text-center mb-4">
                <div class="card-header bg-white border-0 pt-4">
                    <h6 class="text-muted">HARI INI</h6>
                </div>
                <div class="card-body pt-0 pb-4">
                    <div class="calendar-date">{{ date('d') }}</div>
                    <div class="calendar-month text-primary">{{ date('F Y') }}</div>
                    <hr>
                    <p class="mb-0 text-muted"><i class="bi bi-clock me-1"></i> {{ date('l') }}</p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h3 class="card-title"><i class="bi bi-alarm-fill me-2"></i> Deadline Terdekat</h3>
                </div>
                <div class="card-body">
                    <div class="deadline-item">
                        <strong>Pengumpulan Logbook Mingguan</strong>
                        <br>
                        <small class="text-dark">Batas: Minggu, {{ $deadlineTerdekat->format('d M Y') }} (23:59)</small>
                        <div class="mt-2">
                             @if($sisaHari <= 1)
                                <span class="badge bg-danger">Sisa {{ $sisaHari }} Hari! Segera Kumpulkan</span>
                            @else
                                <span class="badge bg-warning text-dark">Sisa {{ $sisaHari }} Hari</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('mahasiswa.logbook.index') }}" class="btn btn-sm btn-outline-danger">
                            Upload Logbook Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Timeline / Agenda --}}
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h3 class="card-title"><i class="bi bi-list-task me-2"></i> Agenda Kegiatan PBL</h3>
                </div>
                <div class="card-body">
                    <div class="timeline-box">
                        {{-- Item 1 --}}
                        <div class="timeline-item">
                            <span class="text-muted small">Minggu 1-4</span>
                            <h6 class="fw-bold mt-1">Perencanaan & Analisis</h6>
                            <p class="text-muted small mb-0">Fokus pada penyusunan proposal, pembagian kelompok, dan analisis kebutuhan sistem.</p>
                        </div>
                        
                        {{-- Item 2 (Aktif) --}}
                        <div class="timeline-item">
                            <span class="badge bg-primary mb-1">SEKARANG</span>
                            <h6 class="fw-bold mt-1 text-primary">Implementasi & Pembuatan Produk</h6>
                            <p class="text-muted small mb-0">Pengembangan aplikasi, coding, dan pengisian logbook mingguan secara rutin.</p>
                        </div>

                        {{-- Item 3 --}}
                        <div class="timeline-item">
                            <span class="text-muted small">Minggu 12-14</span>
                            <h6 class="fw-bold mt-1">Pengujian & Evaluasi</h6>
                            <p class="text-muted small mb-0">Testing aplikasi, penilaian teman sejawat, dan persiapan presentasi akhir.</p>
                        </div>

                         {{-- Item 4 --}}
                         <div class="timeline-item border-0">
                            <span class="text-muted small">Minggu 16</span>
                            <h6 class="fw-bold mt-1">Presentasi Akhir (EXPO)</h6>
                            <p class="text-muted small mb-0">Pameran produk PBL dan penilaian akhir oleh dosen penguji.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection