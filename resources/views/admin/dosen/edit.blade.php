@extends('layout_admin.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Edit Data Dosen</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.dosen.index') }}">Data Dosen</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">Formulir Edit Dosen</h3></div>
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
        
        <form action="{{ route('admin.dosen.update', $dosen->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            {{-- Data Diri Dosen --}}
            <div class="row">
                <div class="col-md-6 mb-3"><label for="kode_admin" class="form-label">NIP</label><input type="text" id="kode_admin" class="form-control" name="kode_admin" value="{{ $dosen->kode_admin }}" required></div>
                <div class="col-md-6 mb-3"><label for="name" class="form-label">Nama Dosen</label><input type="text" id="name" class="form-control" name="name" value="{{ $dosen->name }}" required></div>
                <div class="col-md-6 mb-3"><label for="email" class="form-label">Email</label><input type="email" id="email" class="form-control" name="email" value="{{ $dosen->email }}" required></div>
                <div class="col-md-6 mb-3"><label for="password" class="form-label">Password Baru (Opsional)</label><input type="password" id="password" class="form-control" name="password"><small class="form-text text-muted">Kosongkan jika tidak ingin mengubah.</small></div>
            </div>

            <hr>
            
            {{-- Penugasan Mata Kuliah Dinamis --}}
            <h5>Penugasan Mata Kuliah</h5>
            <div id="assignments-container">
                @foreach($dosen->mataKuliahs as $index => $matkul)
                <div class="row assignment-row mb-2">
                    <div class="col-md-5">
                        <select class="form-select" name="assignments[{{ $index }}][matakuliah_id]" required>
                            <option value="">Pilih Mata Kuliah</option>
                            @foreach($mataKuliahs as $mk) 
                                <option value="{{ $mk->id }}" @if($mk->id == $matkul->id) selected @endif>{{ $mk->nama_mk }}</option> 
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="assignments[{{ $index }}][periode]" required>
                            <option value="sebelum_uts" @if($matkul->pivot->periode == 'sebelum_uts') selected @endif>Sebelum UTS</option>
                            <option value="setelah_uts" @if($matkul->pivot->periode == 'setelah_uts') selected @endif>Setelah UTS</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="assignments[{{ $index }}][kelas]" placeholder="Kelas (cth: 3A)" value="{{ $matkul->pivot->kelas }}" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-assignment-btn">Hapus</button>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" id="add-assignment-btn" class="btn btn-success btn-sm mt-2">
                <i class="bi bi-plus"></i> Tambah Penugasan
            </button>
            
            <hr>
            <button type="submit" class="btn btn-primary">Update</button>
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
    let assignmentIndex = @json($dosen->mataKuliahs->count());
    
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