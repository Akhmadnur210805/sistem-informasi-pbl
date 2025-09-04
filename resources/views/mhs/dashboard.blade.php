@extends('layout.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Dashboard Mahasiswa</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard Mahasiswa</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Selamat Datang di Sistem Informasi PBL</h3>
                </div>
                <div class="card-body">
                    <p>Ini adalah halaman dashboard Anda.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @endsection