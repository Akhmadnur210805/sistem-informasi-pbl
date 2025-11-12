@extends('layout_dosen.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Detail Penilaian: {{ $mahasiswa->name }}</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dosen.rekap.penilaian_sejawat') }}">Rekap Penilaian</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Rincian Penilaian yang Diterima</h3>
    </div>
    <div class="card-body">
        @forelse ($reviewsPerMinggu as $minggu => $reviews)
            <h4 class="mt-3 mb-2">Minggu Ke-{{ $minggu }}</h4>
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th style="width: 20%;">Diberikan Oleh</th>
                        <th style="width: 15%;">Rating</th>
                        <th>Komentar</th>
                        <th style="width: 20%;">Tanggal Menilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviews as $review)
                    <tr>
                        <td>{{ $review->reviewer->name ?? 'User Dihapus' }}</td>
                        <td>
                            <span class="badge bg-primary fs-6">{{ $review->rating }} / 5</span>
                        </td>
                        <td>{{ $review->komentar ?? '-' }}</td>
                        <td>{{ $review->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @empty
            <div class="alert alert-warning text-center">
                Mahasiswa ini belum menerima penilaian sejawat.
            </div>
        @endforelse
    </div>
    <div class="card-footer">
        <a href="{{ route('dosen.rekap.penilaian_sejawat') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Rekap
        </a>
    </div>
</div>
@endsection