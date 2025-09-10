@extends('layout_pengelola.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Data Dosen</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('pengelola.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Dosen</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title">Daftar Dosen</h3></div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIP</th>
                        <th>Nama Dosen</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dosens as $dosen)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $dosen->kode_admin }}</td>
                            <td>{{ $dosen->name }}</td>
                            <td>{{ $dosen->email }}</td>
                            <td>{{ $dosen->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data dosen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection