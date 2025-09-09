@extends('layout_admin.app')

@section('content-header')
    {{-- ... (kode content-header tidak berubah) ... --}}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulir Tambah Dosen</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.dosen.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="kode_admin" class="form-label">NIP</label>
                    <input type="text" class="form-control" id="kode_admin" name="kode_admin" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Dosen</label>
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

                {{-- INPUT BARU UNTUK STATUS --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option selected disabled value="">Pilih Status...</option>
                        <option value="Dosen Pengampu">Dosen Pengampu</option>
                        <option value="Dosen Penguji">Dosen Penguji</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection