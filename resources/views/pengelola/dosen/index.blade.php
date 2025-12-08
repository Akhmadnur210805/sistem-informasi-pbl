@extends('layout_pengelola.app')

@section('content-header')
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark" style="font-weight: 700;">Data Dosen</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('pengelola.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Dosen</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card shadow-none border" style="border-radius: 8px; border-color: #e0e0e0 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    {{-- Header dengan Warna Solid Gelap --}}
                    <thead style="background-color: #343a40; color: #ffffff;">
                        <tr>
                            <th class="py-3 px-4 text-center" style="width: 5%; font-weight: 500;">NO</th>
                            <th class="py-3 px-4" style="width: 20%; font-weight: 500;">NIP / ID</th>
                            <th class="py-3 px-4" style="width: 30%; font-weight: 500;">NAMA DOSEN</th>
                            <th class="py-3 px-4" style="width: 30%; font-weight: 500;">EMAIL</th>
                            <th class="py-3 px-4 text-center" style="width: 15%; font-weight: 500;">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dosens as $dosen)
                            <tr style="border-bottom: 1px solid #f2f2f2;">
                                <td class="py-3 px-4 text-center align-middle text-muted font-weight-bold">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-3 px-4 align-middle">
                                    {{-- Menggunakan font monospace agar angka NIP terlihat rapi sejajar --}}
                                    <span style="font-family: 'Courier New', Courier, monospace; font-weight: 600; color: #333;">
                                        {{ $dosen->kode_admin ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 align-middle">
                                    <span class="text-dark font-weight-bold" style="font-size: 1rem;">
                                        {{ $dosen->name }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 align-middle text-secondary">
                                    {{ $dosen->email }}
                                </td>
                                <td class="py-3 px-4 align-middle text-center">
                                    {{-- Indikator Status dengan Titik (Dot Indicator) --}}
                                    @if(strtolower($dosen->status) == 'aktif')
                                        <div class="d-inline-flex align-items-center px-3 py-1 rounded" style="background-color: #e8f5e9; border: 1px solid #c8e6c9;">
                                            <span style="height: 8px; width: 8px; background-color: #28a745; border-radius: 50%; display: inline-block; margin-right: 8px;"></span>
                                            <span style="color: #2e7d32; font-weight: 600; font-size: 0.8rem;">Aktif</span>
                                        </div>
                                    @else
                                        <div class="d-inline-flex align-items-center px-3 py-1 rounded" style="background-color: #ffebee; border: 1px solid #ffcdd2;">
                                            <span style="height: 8px; width: 8px; background-color: #d32f2f; border-radius: 50%; display: inline-block; margin-right: 8px;"></span>
                                            <span style="color: #c62828; font-weight: 600; font-size: 0.8rem;">Non-Aktif</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    Data dosen belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection