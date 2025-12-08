@extends('layout_admin.app')

@section('styles')
<style>

    .group-card .card-header .card-title {
    color: #000 !important;
    font-weight: 600 !important;
}

    /* Efek Hover pada Kartu Kelompok */
    .group-card {
        transition: all 0.3s ease;
        border: none;
        border-top: 3px solid #007bff; /* Default Blue */
    }
    .group-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    /* Warna-warni border atas kartu berdasarkan urutan (Opsional, agar bervariasi) */
    .group-card.card-primary { border-top-color: #007bff; }
    .group-card.card-success { border-top-color: #28a745; }
    .group-card.card-warning { border-top-color: #ffc107; }
    .group-card.card-info    { border-top-color: #17a2b8; }

    /* Styling List Anggota */
    .member-item {
        border-bottom: 1px solid #f4f6f9;
        padding: 10px 0;
        display: flex;
        align-items: center;
    }
    .member-item:last-child {
        border-bottom: none;
    }
    .member-avatar {
        width: 35px;
        height: 35px;
        background-color: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        color: #495057;
        font-weight: bold;
        font-size: 14px;
    }
</style>
@endsection

@section('content-header')
    <div class="row mb-3 align-items-end">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark" style="font-weight: 700;">Data Kelompok</h1>
            <p class="text-muted small mb-0">Rekapitulasi pembagian kelompok mahasiswa per kelas</p>
        </div>
        <div class="col-sm-6">
            {{-- Perbaikan: Menggunakan float-sm-right untuk AdminLTE 3 --}}
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Kelompok</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    @forelse ($kelompoks as $kelas => $kelompokPerKelas)
        
        {{-- Header Kelas dengan Desain Badge Modern --}}
        <div class="d-flex align-items-center mb-3 mt-4">
            <div class="bg-navy px-3 py-2 rounded mr-3">
                <i class="fas fa-layer-group"></i>
            </div>
            <h4 class="mb-0 text-dark font-weight-bold">
                Kelas {{ $kelas }}
                <small class="text-muted text-sm ml-2 font-weight-normal">({{ count($kelompokPerKelas) }} Kelompok)</small>
            </h4>
        </div>

        <div class="row">
            @php $i = 0; @endphp
            @foreach ($kelompokPerKelas as $namaKelompok => $anggotas)
                {{-- Logika warna-warni kartu (Primary, Success, Warning, Info) --}}
                @php
                    $colors = ['card-primary', 'card-success', 'card-warning', 'card-info'];
                    $colorClass = $colors[$i % 4];
                    $badgeColor = str_replace('card-', 'bg-', $colorClass);
                    $i++;
                @endphp

                {{-- Grid Layout: col-md-6 (Tablet), col-lg-4 (Desktop), col-xl-4 (Large Screen) --}}
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card shadow-sm h-100 group-card {{ $colorClass }}">
                        <div class="card-header bg-white border-bottom-0 pt-3 pb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title text-bold" style="font-size: 1.1rem;">
                                    {{ $namaKelompok }}
                                </h3>
                                <span class="badge {{ $badgeColor }} elevation-1" style="font-size: 0.8rem;">
                                    {{ count($anggotas) }} Anggota
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-body pt-0">
                            <div class="mt-2" style="max-height: 250px; overflow-y: auto;">
                                @foreach ($anggotas as $anggota)
                                    <div class="member-item">
                                        {{-- Avatar Inisial --}}
                                        <div class="member-avatar shadow-sm">
                                            {{ substr($anggota->name, 0, 1) }}
                                        </div>
                                        <div class="d-flex flex-column" style="line-height: 1.2;">
                                            <span class="text-dark font-weight-bold" style="font-size: 0.95rem;">
                                                {{ $anggota->name }}
                                            </span>
                                            <span class="text-muted" style="font-size: 0.8rem;">
                                                NIM: {{ $anggota->kode_admin }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        {{-- Footer Card (Opsional, untuk hiasan) --}}
                        <div class="card-footer bg-white border-top-0 pt-0 pb-3">
                            <small class="text-muted">
                                <i class="fas fa-users mr-1"></i> Tim Mahasiswa
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        {{-- Garis pemisah antar kelas --}}
        @if(!$loop->last)
            <hr class="my-4" style="border-top: 1px dashed #ccc;">
        @endif

    @empty
        <div class="col-12">
            <div class="alert alert-light border text-center py-5 shadow-sm">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada data kelompok yang terbentuk.</h5>
                <p class="text-secondary small">Silakan pastikan mahasiswa sudah memiliki kelompok.</p>
            </div>
        </div>
    @endforelse
</div>
@endsection