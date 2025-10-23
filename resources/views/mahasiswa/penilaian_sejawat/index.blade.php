@extends('layout_mahasiswa.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Penilaian Teman Sejawat</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('mahasiswa.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Penilaian Sejawat</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Penilaian --}}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Formulir Penilaian</h3>
        </div>
        <form action="{{ route('mahasiswa.penilaian_sejawat.store') }}" method="POST">
            @csrf
            <div class="card-body">
                @if ($teammates->isEmpty())
                    <div class="alert alert-warning text-center">
                        Anda tidak memiliki teman satu kelompok untuk dinilai.
                    </div>
                @else
                    <div class="mb-3 col-md-3">
                        <label for="minggu_ke" class="form-label">Penilaian untuk Minggu Ke-</label>
                        <input type="number" class="form-control" id="minggu_ke" name="minggu_ke" value="{{ old('minggu_ke', 1) }}" required min="1">
                    </div>
                    <p>Berikan penilaian dan komentar terhadap kontribusi teman satu kelompok Anda pada minggu ini.</p>
                    
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Teman</th>
                                <th style="width: 20%;">Penilaian (1-5)</th>
                                <th style="width: 40%;">Komentar (Opsional)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teammates as $teammate)
                                <tr>
                                    <td><strong>{{ $teammate->name }}</strong></td>
                                    <td>
                                        <select name="ratings[{{ $teammate->id }}]" class="form-select" required>
                                            <option value="" disabled selected>Pilih nilai...</option>
                                            <option value="1">1 - Sangat Kurang</option>
                                            <option value="2">2 - Kurang</option>
                                            <option value="3">3 - Cukup</option>
                                            <option value="4">4 - Baik</option>
                                            <option value="5">5 - Sangat Baik</option>
                                        </select>
                                    </td>
                                    <td>
                                        <textarea name="komentars[{{ $teammate->id }}]" class="form-control" rows="1" placeholder="Masukkan umpan balik..."></textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            @if ($teammates->isNotEmpty())
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle-fill me-1"></i> Simpan Penilaian
                    </button>
                </div>
            @endif
        </form>
    </div>

    {{-- BAGIAN BARU: RIWAYAT PENILAIAN --}}
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Riwayat Penilaian Anda</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 10%;">Minggu Ke-</th>
                        <th>Nama Teman</th>
                        <th style="width: 15%;">Rating</th>
                        <th>Komentar</th>
                        <th style="width: 20%;">Tanggal Penilaian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviewHistory as $review)
                        <tr>
                            <td><strong>{{ $review->minggu_ke }}</strong></td>
                            <td>{{ $review->reviewed->name ?? 'User Dihapus' }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $review->rating }} / 5</span>
                            </td>
                            <td>{{ $review->komentar ?? '-' }}</td>
                            <td>{{ $review->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Anda belum pernah memberikan penilaian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- AKHIR BAGIAN BARU --}}
@endsection