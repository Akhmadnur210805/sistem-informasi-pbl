@extends('layout_admin.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Edit Data Pengelola</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.pengelola.index') }}">Data Pengelola</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulir Edit Pengelola</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pengelola.update', $pengelola->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="kode_admin" class="form-label">ID Pengelola</label>
                    <input type="text" class="form-control" name="kode_admin" value="{{ $pengelola->kode_admin }}" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Pengelola</label>
                    <input type="text" class="form-control" name="name" value="{{ $pengelola->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $pengelola->email }}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru (Opsional)</label>
                    <input type="password" class="form-control" name="password">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                </div>
                <div class="mb-3">
                    <label for="jenis_pengelola" class="form-label">Jenis Pengelola</label>
                    <select class="form-select" name="jenis_pengelola" required>
                        <option value="Pengelola Dosen" {{ $pengelola->jenis_pengelola == 'Pengelola Dosen' ? 'selected' : '' }}>Pengelola Dosen</option>
                        <option value="Pengelola Mahasiswa" {{ $pengelola->jenis_pengelola == 'Pengelola Mahasiswa' ? 'selected' : '' }}>Pengelola Mahasiswa</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.pengelola.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection