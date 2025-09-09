@extends('layout_dosen.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Data Kelompok PBL</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kelompok PBL</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        @forelse ($kelompoks as $kelas => $kelompokPerKelas)
            <div class="card card-outline card-success collapsed-card mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-folder-fill me-2"></i>
                        Kelas <strong>{{ $kelas }}</strong>
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="accordion" id="accordionKelas{{ $kelas }}">
                        @foreach ($kelompokPerKelas as $namaKelompok => $anggotas)
                            <div class="card mb-0 rounded-0 border-bottom">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center" id="headingKelompok{{ Str::slug($namaKelompok) }}{{ $kelas }}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link text-decoration-none text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKelompok{{ Str::slug($namaKelompok) }}{{ $kelas }}" aria-expanded="true" aria-controls="collapseKelompok{{ Str::slug($namaKelompok) }}{{ $kelas }}">
                                            <i class="bi bi-people-fill me-2"></i>
                                            <strong>{{ $namaKelompok }}</strong>
                                        </button>
                                    </h2>
                                    <span class="badge bg-info float-end">{{ count($anggotas) }} Anggota</span>
                                </div>

                                <div id="collapseKelompok{{ Str::slug($namaKelompok) }}{{ $kelas }}" class="collapse" aria-labelledby="headingKelompok{{ Str::slug($namaKelompok) }}{{ $kelas }}" data-bs-parent="#accordionKelas{{ $kelas }}">
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush border-0">
                                            @foreach ($anggotas as $anggota)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="bi bi-person-circle me-2"></i>
                                                        {{ $anggota->name }}
                                                    </div>
                                                    <span class="text-muted">{{ $anggota->kode_admin }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Belum ada data kelompok yang terbentuk.
                </div>
            </div>
        @endforelse
    </div>
@endsection

@section('scripts')
    {{-- Script untuk mengaktifkan accordion AdminLTE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi AdminLTE collapse card
            const collapseCards = document.querySelectorAll('[data-lte-toggle="card-collapse"]');
            collapseCards.forEach(button => {
                button.addEventListener('click', function() {
                    const card = this.closest('.card');
                    if (card) {
                        card.classList.toggle('collapsed-card');
                        const icon = this.querySelector('i');
                        if (icon) {
                            if (card.classList.contains('collapsed-card')) {
                                icon.classList.remove('bi-dash-lg');
                                icon.classList.add('bi-plus-lg');
                            } else {
                                icon.classList.remove('bi-plus-lg');
                                icon.classList.add('bi-dash-lg');
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection