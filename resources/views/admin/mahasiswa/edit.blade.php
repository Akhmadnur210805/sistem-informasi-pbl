@extends('layout_admin.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Edit Data Mahasiswa</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.mahasiswa.index') }}">Data Mahasiswa</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulir Edit Mahasiswa</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="kode_admin" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="kode_admin" name="kode_admin" value="{{ $mahasiswa->kode_admin }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $mahasiswa->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $mahasiswa->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru (Opsional)</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select class="form-select" id="kelas" name="kelas" required>
                                <option disabled value="">Pilih Kelas...</option>
                                @foreach(['A', 'B', 'C', 'D', 'E', 'F'] as $kelas)
                                    <option value="{{ $kelas }}" {{ $mahasiswa->kelas == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kelompok" class="form-label">Nama Kelompok</label>
                            <select class="form-select" id="kelompok" name="kelompok" required>
                                <option disabled value="">Pilih Kelompok...</option>
                                @for ($i = 1; $i <= 8; $i++)
                                    <option value="Kelompok {{ $i }}" {{ $mahasiswa->kelompok == 'Kelompok '.$i ? 'selected' : '' }}>Kelompok {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection