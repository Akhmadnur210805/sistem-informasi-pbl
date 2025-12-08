@extends('layout_admin.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Data Dosen</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Dosen</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Dosen</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bi bi-file-earmark-excel-fill"></i> Import Excel
                </button>
                <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Data
                </a>
            </div>
        </div>
        
        <div class="card-body p-0">
            {{-- PERBAIKAN: Menambahkan wrapper table-responsive agar layout tidak pecah --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIP</th>
                            <th>Nama Dosen</th>
                            <th>Email</th>
                            <th class="text-center">Status</th>
                            <th>Mata Kuliah (Pra-UTS)</th>
                            <th>Mata Kuliah (Pasca-UTS)</th>
                            <th style="width: 150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dosens as $dosen)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $dosen->kode_admin }}</td>
                                <td>{{ $dosen->name }}</td>
                                <td>{{ $dosen->email }}</td>

                                <td class="text-center">
                                    <form action="{{ route('admin.dosen.toggleStatus', $dosen->id) }}" method="POST">
                                        @csrf
                                        @if(strtolower($dosen->status) == 'aktif')
                                            <button type="submit" class="btn badge bg-success border-0" style="cursor: pointer;" onclick="return confirm('Non-aktifkan dosen ini?')">
                                                Aktif
                                            </button>
                                        @else
                                            <button type="submit" class="btn badge bg-danger border-0" style="cursor: pointer;" onclick="return confirm('Aktifkan dosen ini?')">
                                                Non-Aktif
                                            </button>
                                        @endif
                                    </form>
                                </td>

                                <td>
                                    @forelse ($dosen->mataKuliahSebelumUts as $matkul)
                                        <span class="badge bg-primary">
                                            {{ $matkul->nama_mk }} ({{ $matkul->pivot->kelas }})
                                        </span>
                                    @empty
                                        <span class="text-muted small">-</span>
                                    @endforelse
                                </td>
                                <td>
                                    @forelse ($dosen->mataKuliahSetelahUts as $matkul)
                                        <span class="badge bg-info text-dark">
                                            {{ $matkul->nama_mk }} ({{ $matkul->pivot->kelas }})
                                        </span>
                                    @empty
                                        <span class="text-muted small">-</span>
                                    @endforelse
                                </td>
                                <td>
                                    <a href="{{ route('admin.dosen.edit', $dosen->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('admin.dosen.destroy', $dosen->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">Tidak ada data dosen.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> {{-- Akhir table-responsive --}}
        </div>
    </div>

    {{-- MODAL IMPORT EXCEL --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data Dosen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.dosen.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info small">
                            <b>Format Excel:</b> <br>
                            nip, nama, email, password, kode_mk, periode, kelas
                        </div>
                        <div class="mb-3">
                            <label for="file_excel" class="form-label">Pilih File Excel</label>
                            <input class="form-control" type="file" name="file_excel" id="file_excel" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection