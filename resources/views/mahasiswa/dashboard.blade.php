@extends('layout_mahasiswa.app')

@section('styles')
<style>
    /* Memberi warna latar belakang pada area konten */
    .app-content {
        background-color: #f4f6f9;
    }
    .welcome-banner {
        background: linear-gradient(90deg, rgba(67,97,238,1) 0%, rgba(37,65,201,1) 100%);
        color: white;
        padding: 2rem;
        border-radius: 0.75rem;
    }
    .progress-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-size: 1.5rem;
        font-weight: bold;
        color: #1cc88a;
    }
</style>
@endsection

@section('content-header')
    {{-- Welcome Banner --}}
    <div class="welcome-banner">
        <h2>Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="lead mb-0">Jangan lewatkan deadline proyekmu minggu ini!</p>
    </div>
@endsection

@section('content')
    <div class="row">
        {{-- Kolom Kiri --}}
        <div class="col-lg-7">
            {{-- Proyek Aktif --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Proyek Aktif</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="progress-circle" style="background: conic-gradient(#1cc88a 75%, #e9ecef 0);">
                            <span>75%</span>
                        </div>
                        <div class="ms-4">
                            <h5>Proyek Akhir: Sistem Informasi PBL</h5>
                            <p class="mb-1 text-muted">Kelompok: {{ Auth::user()->kelompok ?? 'Belum ada' }}</p>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 75%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div class="col-lg-5">
             {{-- Placeholder Kalender --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Kalender & Agenda</h6></div>
                <div class="card-body text-center">
                    <p>Tampilan Kalender akan ada di sini.</p>
                    <i class="bi bi-calendar3" style="font-size: 3rem; color: #dddfeb;"></i>
                </div>
            </div>
        </div>
    </div>
    
    {{-- BAGIAN RANKING SUDAH DIHAPUS DARI SINI --}}

@endsection