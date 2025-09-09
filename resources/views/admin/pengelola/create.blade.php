@extends('layout_admin.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Tambah Data Pengelola</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.pengelola.index') }}">Data Pengelola</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulir Tambah Pengelola</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pengelola.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="kode_admin" class="form-label">ID Pengelola</label>
                    <input type="text" class="form-control" id="kode_admin" name="kode_admin" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Pengelola</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="jenis_pengelola" class="form-label">Jenis Pengelola</label>
                    <select class="form-select" id="jenis_pengelola" name="jenis_pengelola" required>
                        <option selected disabled value="">Pilih Jenis...</option>
                        <option value="Pengelola Dosen">Pengelola Dosen</option>
                        <option value="Pengelola Mahasiswa">Pengelola Mahasiswa</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.pengelola.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection