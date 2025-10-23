@extends('layout_dosen.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Penilaian Proyek</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Penilaian</li>
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

    <div class="card">
        <div class="card-header"><h3 class="card-title">Pilih Penugasan Mata Kuliah</h3></div>
        <div class="card-body">
            <p>Silakan pilih mata kuliah dan kelas yang akan dinilai.</p>
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Mata Kuliah</th>
                        <th>Kelas</th>
                        <th>Periode</th>
                        <th style="width: 120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penugasans as $penugasan)
                        <tr>
                            <td><strong>{{ $penugasan->nama_mk }}</strong></td>
                            <td>{{ $penugasan->pivot->kelas }}</td>
                            <td>
                                @if($penugasan->pivot->periode == 'sebelum_uts')
                                    <span class="badge bg-primary">Sebelum UTS</span>
                                @else
                                    <span class="badge bg-info text-dark">Setelah UTS</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dosen.penilaian.form', ['matakuliah' => $penugasan->id, 'kelas' => $penugasan->pivot->kelas]) }}" class="btn btn-primary w-100">
                                    <i class="bi bi-card-checklist me-1"></i> Beri Nilai
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                Anda belum memiliki penugasan mata kuliah. Silakan hubungi Admin.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection