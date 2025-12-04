@extends('layout_dosen.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Detail Penilaian Sejawat</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dosen.rekap.penilaian_sejawat') }}">Rekap</a></li>
                <li class="breadcrumb-item active">Detail {{ $mahasiswa->name }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Rincian Penilaian untuk: <strong>{{ $mahasiswa->name }}</strong></h3>
    </div>
    <div class="card-body">
        @forelse($reviewsPerWeek as $minggu => $reviews)
            <h5 class="mt-3 text-primary">Minggu ke-{{ $minggu }}</h5>
            <table class="table table-bordered table-sm mb-4">
                <thead class="table-light">
                    <tr>
                        <th style="width: 30%;">Dinilai Oleh</th>
                        <th style="width: 10%;">Rating</th>
                        <th>Komentar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                    <tr>
                        <td>{{ $review->reviewer->name }}</td>
                        <td><span class="badge bg-info">{{ $review->rating }}</span></td>
                        <td>{{ $review->komentar ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @empty
            <p class="text-center text-muted">Belum ada data penilaian detail.</p>
        @endforelse
    </div>
    <div class="card-footer">
        <a href="{{ route('dosen.rekap.penilaian_sejawat') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection