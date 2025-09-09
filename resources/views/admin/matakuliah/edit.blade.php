@extends('layout_admin.app')
@section('content-header')
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Edit Mata Kuliah</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.matakuliah.index') }}">Data Mata Kuliah</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title">Formulir Edit Mata Kuliah</h3></div>
        <div class="card-body">
            <form action="{{ route('admin.matakuliah.update', $matakuliah->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Kode Mata Kuliah</label>
                    <input type="text" class="form-control" name="kode_mk" value="{{ $matakuliah->kode_mk }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Mata Kuliah</label>
                    <input type="text" class="form-control" name="nama_mk" value="{{ $matakuliah->nama_mk }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah SKS</label>
                    <input type="number" class="form-control" name="sks" value="{{ $matakuliah->sks }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.matakuliah.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection