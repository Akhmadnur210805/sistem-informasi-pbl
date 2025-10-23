@extends('layout_dosen.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Rekapitulasi Penilaian Sejawat</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rekap Penilaian Sejawat</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">Rata-rata Penilaian yang Diterima per Minggu</h3></div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead class="table-light">
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Kelas</th>
                    <th>Rata-rata Poin</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mahasiswas as $mahasiswa)
                <tr>
                    <td><strong>{{ $mahasiswa->name }}</strong></td>
                    <td>{{ $mahasiswa->kelas }}</td>
                    <td>
                        @php
                            // Menghitung rata-rata rating
                            $avgRating = $mahasiswa->peerReviewsReceived->avg('rating');
                        @endphp
                        <span class="badge bg-primary fs-6">
                            {{ number_format($avgRating, 2) }} / 5.00
                        </span>
                        <small class="text-muted"> (dari {{ $mahasiswa->peerReviewsReceived->count() }} penilaian)</small>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center">Belum ada data penilaian sejawat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection