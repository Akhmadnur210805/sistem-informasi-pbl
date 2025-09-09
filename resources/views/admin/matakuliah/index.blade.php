@extends('layout_admin.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Data Mata Kuliah</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Mata Kuliah</li>
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
        <div class="card-header">
            <h3 class="card-title">Daftar Mata Kuliah</h3>
            <div class="card-tools">
                <a href="{{ route('admin.matakuliah.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Data
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mataKuliahs as $matakuliah)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $matakuliah->kode_mk }}</td>
                            <td>{{ $matakuliah->nama_mk }}</td>
                            <td>{{ $matakuliah->sks }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.matakuliah.edit', $matakuliah->id) }}" class="btn btn-primary btn-sm me-1">Edit</a>
                                    <form action="{{ route('admin.matakuliah.destroy', $matakuliah->id) }}" method="POST" onsubmit="return confirm('Yakin?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection