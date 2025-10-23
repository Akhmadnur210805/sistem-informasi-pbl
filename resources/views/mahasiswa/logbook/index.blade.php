@extends('layout_mahasiswa.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Milestone / Logbook Mingguan</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('mahasiswa.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Logbook</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    {{-- Menampilkan pesan sukses atau error --}}
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

    {{-- Form Pengumpulan Logbook --}}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Form Pengumpulan Logbook</h3>
        </div>
        <form action="{{ route('mahasiswa.logbook.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="minggu_ke" class="form-label">Minggu Ke-</label>
                            <input type="number" class="form-control" id="minggu_ke" name="minggu_ke" value="{{ old('minggu_ke') }}" required min="1">
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Kegiatan</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan progres yang telah Anda lakukan minggu ini..." required>{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="file_logbook" class="form-label">Unggah File (Opsional)</label>
                    <input class="form-control" type="file" id="file_logbook" name="file_logbook">
                    <small class="form-text text-muted">Format yang diizinkan: PDF, DOC, DOCX, ZIP. Maksimal 5MB.</small>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-cloud-arrow-up-fill me-1"></i> Unggah Logbook
                </button>
            </div>
        </form>
    </div>

    {{-- Riwayat Pengumpulan --}}
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Riwayat Pengumpulan</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 10%;">Minggu Ke-</th>
                        <th>Deskripsi</th>
                        <th style="width: 20%;">File Terunggah</th>
                        <th style="width: 20%;">Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logbooks as $logbook)
                        <tr>
                            <td><strong>{{ $logbook->minggu_ke }}</strong></td>
                            <td>{{ $logbook->deskripsi }}</td>
                            <td>
                                @if ($logbook->file_path)
                                    <a href="{{ asset('storage/' . $logbook->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download me-1"></i> Download File
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $logbook->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada logbook yang diunggah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection