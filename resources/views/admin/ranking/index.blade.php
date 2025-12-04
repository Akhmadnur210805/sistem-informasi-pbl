@extends('layout_admin.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Peringkat Keseluruhan</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ranking</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    {{-- FORM FILTER --}}
    <div class="card card-outline card-primary mb-4">
        <div class="card-body py-3">
            <form action="{{ route('admin.ranking.index') }}" method="GET">
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <label class="col-form-label fw-bold"><i class="bi bi-funnel-fill me-1"></i> Filter:</label>
                    </div>
                    {{-- Filter Angkatan --}}
                    <div class="col-md-3">
                        <select name="angkatan" class="form-select">
                            <option value="Semua Angkatan">Semua Angkatan</option>
                            @foreach ($angkatanList as $thn)
                                <option value="{{ $thn }}" {{ $selectedAngkatan == $thn ? 'selected' : '' }}>
                                    Angkatan {{ $thn }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Filter Kelas --}}
                    <div class="col-md-3">
                        <select name="kelas" class="form-select">
                            <option value="Semua Kelas">Semua Kelas</option>
                            @foreach ($kelasList as $k)
                                <option value="{{ $k }}" {{ $selectedKelas == $k ? 'selected' : '' }}>
                                    Kelas {{ $k }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Tombol Terapkan --}}
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Terapkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        {{-- TABEL 1: RANKING MAHASISWA --}}
        <div class="col-lg-6">
            <div class="card card-outline card-primary h-100">
                <div class="card-header">
                    <h3 class="card-title"><i class="bi bi-trophy-fill text-warning me-2"></i>Ranking Mahasiswa Terbaik</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nama Mahasiswa</th>
                                <th>Angkatan</th>
                                <th>Kelas</th>
                                <th class="text-center">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mahasiswas as $mahasiswa)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>
                                        <strong>{{ $mahasiswa->name }}</strong>
                                        <br><small class="text-muted">{{ $mahasiswa->kode_admin }}</small>
                                    </td>
                                    <td>{{ $mahasiswa->angkatan ?? '-' }}</td>
                                    <td>{{ $mahasiswa->kelas }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success fs-6">
                                            {{ number_format($mahasiswa->skor_akhir_mahasiswa, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-4 text-muted">
                                        Data mahasiswa tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TABEL 2: RANKING KELOMPOK --}}
        <div class="col-lg-6">
            <div class="card card-outline card-success h-100">
                <div class="card-header">
                    <h3 class="card-title"><i class="bi bi-people-fill text-success me-2"></i>Ranking Kelompok Terbaik</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Kelompok</th>
                                <th>Angkatan</th>
                                <th>Kelas</th>
                                <th class="text-center">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kelompoks as $kelompok)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td><strong>{{ $kelompok->kelompok }}</strong></td>
                                    <td>{{ $kelompok->angkatan }}</td>
                                    <td>{{ $kelompok->kelas }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success fs-6">
                                            {{ number_format($kelompok->skor_akhir, 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-4 text-muted">
                                        Data kelompok tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection