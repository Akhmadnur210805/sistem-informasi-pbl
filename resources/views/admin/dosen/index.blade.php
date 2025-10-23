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
            {{-- ... kode tabel Anda tidak berubah ... --}}
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIP</th>
                        <th>Nama Dosen</th>
                        <th>Email</th>
                        <th>Mata Kuliah Sebelum UTS</th>
                        <th>Mata Kuliah Setelah UTS</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dosens as $dosen)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $dosen->kode_admin }}</td>
                            <td>{{ $dosen->name }}</td>
                            <td>{{ $dosen->email }}</td>
                            <td>
                                @forelse ($dosen->mataKuliahSebelumUts as $matkul)
                                    <span class="badge bg-primary">
                                        {{ $matkul->nama_mk }} ({{ $matkul->pivot->kelas }})
                                    </span>
                                @empty
                                    <span class="badge bg-secondary">Belum ada</span>
                                @endforelse
                            </td>
                            <td>
                                @forelse ($dosen->mataKuliahSetelahUts as $matkul)
                                    <span class="badge bg-info text-dark">
                                        {{ $matkul->nama_mk }} ({{ $matkul->pivot->kelas }})
                                    </span>
                                @empty
                                    <span class="badge bg-secondary">Belum ada</span>
                                @endforelse
                            </td>
                            <td>
                                <a href="{{ route('admin.dosen.edit', $dosen->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.dosen.destroy', $dosen->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data dosen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL UNTUK IMPORT EXCEL --}}
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
                        <div class="alert alert-info">
                            <b>Penting!</b> Format file Excel harus memiliki header berikut: <br>
                            <code class="text-dark">nip, nama, email, password, kode_mk, periode, kelas</code><br><br>
                            Satu baris mewakili satu penugasan. Isi `periode` dengan `sebelum_uts` atau `setelah_uts`.
                        </div>
                        <div class="mb-3">
                            <label for="file_excel" class="form-label">Pilih File Excel (.xlsx, .xls)</label>
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