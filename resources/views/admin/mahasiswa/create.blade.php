@extends('layout_admin.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Tambah Data Mahasiswa</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.mahasiswa.index') }}">Data Mahasiswa</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulir Tambah Mahasiswa</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="kode_admin" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="kode_admin" name="kode_admin" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="angkatan" class="form-label">Angkatan</label>
                            <input type="number" class="form-control" id="angkatan" name="angkatan" 
                                value="{{ old('angkatan', $mahasiswa->angkatan ?? date('Y')) }}" 
                                placeholder="Contoh: 2023" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        {{-- INI BAGIAN YANG DIPERBARUI --}}
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select class="form-select" id="kelas" name="kelas" required>
                                <option selected disabled value="">Pilih Kelas...</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kelompok" class="form-label">Nama Kelompok</label>
                            <select class="form-select" id="kelompok" name="kelompok" required>
                                <option selected disabled value="">Pilih Kelompok...</option>
                                @for ($i = 1; $i <= 8; $i++)
                                    <option value="Kelompok {{ $i }}">Kelompok {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection