@extends('layout_admin.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Tambah Data Dosen</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.dosen.index') }}">Data Dosen</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulir Tambah Dosen</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('admin.dosen.store') }}" method="POST">
            @csrf
            
            {{-- Data Diri Dosen --}}
            <div class="row">
                <div class="col-md-6 mb-3"><label for="kode_admin" class="form-label">NIP</label><input type="text" id="kode_admin" class="form-control" name="kode_admin" value="{{ old('kode_admin') }}" required></div>
                <div class="col-md-6 mb-3"><label for="name" class="form-label">Nama Dosen</label><input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" required></div>
                <div class="col-md-6 mb-3"><label for="email" class="form-label">Email</label><input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" required></div>
                <div class="col-md-6 mb-3"><label for="password" class="form-label">Password</label><input type="password" id="password" class="form-control" name="password" required></div>
            </div>

            <hr>
            
            {{-- Penugasan Mata Kuliah Dinamis --}}
            <h5>Penugasan Mata Kuliah</h5>
            <div id="assignments-container">
                {{-- Kontainer untuk baris penugasan yang ditambahkan secara dinamis --}}
            </div>
            <button type="button" id="add-assignment-btn" class="btn btn-success btn-sm mt-2">
                <i class="bi bi-plus"></i> Tambah Penugasan
            </button>
            
            <hr>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

{{-- Template untuk baris baru (disembunyikan) --}}
<div id="assignment-template" style="display: none;">
    <div class="row assignment-row mb-2">
        <div class="col-md-5">
            <select class="form-select" name="assignments[__INDEX__][matakuliah_id]" required>
                <option value="" selected disabled>Pilih Mata Kuliah...</option>
                @foreach($mataKuliahs as $mk)
                    <option value="{{ $mk->id }}">{{ $mk->nama_mk }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select" name="assignments[__INDEX__][periode]" required>
                <option value="sebelum_uts">Sebelum UTS</option>
                <option value="setelah_uts">Setelah UTS</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" name="assignments[__INDEX__][kelas]" placeholder="Kelas (cth: 3A)" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-assignment-btn">Hapus</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let assignmentIndex = 0;
    
    document.getElementById('add-assignment-btn').addEventListener('click', function () {
        const template = document.getElementById('assignment-template').innerHTML;
        const newRowHtml = template.replace(/__INDEX__/g, assignmentIndex);
        document.getElementById('assignments-container').insertAdjacentHTML('beforeend', newRowHtml);
        assignmentIndex++;
    });

    document.getElementById('assignments-container').addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-assignment-btn')) {
            e.target.closest('.assignment-row').remove();
        }
    });
});
</script>
@endpush