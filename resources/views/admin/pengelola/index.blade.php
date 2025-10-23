@extends('layout_admin.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Data Pengelola</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Pengelola</li>
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
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Pengelola</h3>
            <div class="card-tools">
                {{-- TOMBOL BARU UNTUK IMPORT --}}
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bi bi-file-earmark-excel-fill"></i> Import Excel
                </button>

                <a href="{{ route('admin.pengelola.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Data
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>ID Pengelola</th>
                        <th>Nama Pengelola</th>
                        <th>Email</th>
                        <th>Jenis Pengelola</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengelolas as $pengelola)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $pengelola->kode_admin }}</td>
                            <td>{{ $pengelola->name }}</td>
                            <td>{{ $pengelola->email }}</td>
                            <td>{{ $pengelola->jenis_pengelola }}</td>
                            <td>
                                <a href="{{ route('admin.pengelola.edit', $pengelola->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.pengelola.destroy', $pengelola->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pengelola.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL BARU UNTUK IMPORT --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data Pengelola</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.pengelola.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <b>Penting!</b> Pastikan baris pertama file Excel Anda adalah header dengan nama kolom: <br>
                            <code class="text-dark">id_pengelola, nama, email, jenis_pengelola, password</code>
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