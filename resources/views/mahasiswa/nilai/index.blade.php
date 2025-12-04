@extends('layout_mahasiswa.app')

@section('content-header')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Hasil Penilaian Studi</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('mahasiswa.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hasil Penilaian</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    
    {{-- BAGIAN 1: TABEL RINCIAN NILAI INDIVIDU --}}
    <div class="card card-outline card-primary mb-4">
        <div class="card-header">
            <h3 class="card-title"><i class="bi bi-journal-text me-2"></i>Rincian Nilai Mata Kuliah (Individu)</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">#</th>
                        <th>Mata Kuliah</th>
                        <th>Periode</th>
                        <th class="text-center">Nilai Proyek</th>
                        <th class="text-center">Nilai Presentasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($nilais as $nilai)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $nilai->mataKuliah->nama_mk }}</strong><br>
                                <small class="text-muted">{{ $nilai->mataKuliah->kode_mk }} - {{ $nilai->mataKuliah->sks }} SKS</small>
                            </td>
                            <td>
                                @if($nilai->periode == 'sebelum_uts')
                                    <span class="badge bg-info text-dark">Sebelum UTS</span>
                                @else
                                    <span class="badge bg-primary">Setelah UTS</span>
                                @endif
                            </td>
                            
                            <td class="text-center">
                                @if($nilai->nilai) <span class="fw-bold">{{ $nilai->nilai }}</span> @else <span class="text-muted">-</span> @endif
                            </td>

                            <td class="text-center">
                                @if($nilai->nilai_presentasi) <span class="fw-bold">{{ $nilai->nilai_presentasi }}</span> @else <span class="text-muted">-</span> @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Belum ada nilai yang dimasukkan oleh dosen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        {{-- BAGIAN 2: NILAI KELOMPOK (RATA-RATA) --}}
        <div class="col-md-6">
            <div class="card card-outline card-success h-100">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-people-fill me-2"></i>Nilai Kelompok 
                        <small class="text-muted">(Rata-rata)</small>
                    </h3>
                </div>
                <div class="card-body">
                    @if($nilaiKelompok)
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Hasil Proyek (50%)
                                <span class="badge bg-success rounded-pill fs-6">{{ number_format($nilaiKelompok['proyek'], 1) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Kerja Sama (30%)
                                <span class="badge bg-primary rounded-pill fs-6">{{ number_format($nilaiKelompok['kerjasama'], 1) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Presentasi Kelompok (20%)
                                <span class="badge bg-info rounded-pill fs-6">{{ number_format($nilaiKelompok['presentasi'], 1) }}</span>
                            </li>
                        </ul>
                        
                        @php
                            // Hitung Skor Akhir Kelompok (SAW)
                            $skorKelompok = ($nilaiKelompok['proyek'] * 0.5) + 
                                            ($nilaiKelompok['kerjasama'] * 0.3) + 
                                            ($nilaiKelompok['presentasi'] * 0.2);
                        @endphp
                        <div class="alert alert-success mt-3 text-center mb-0">
                            <strong>Skor Kelompok: {{ number_format($skorKelompok, 2) }}</strong>
                        </div>
                    @else
                        <p class="text-center text-muted py-4">Belum ada nilai kelompok.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- BAGIAN 3: SKOR AKHIR MAHASISWA (SAW) --}}
        <div class="col-md-6">
            <div class="card card-outline card-warning h-100">
                <div class="card-header">
                    <h3 class="card-title"><i class="bi bi-trophy-fill me-2"></i>Estimasi Skor Akhir (Ranking)</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Rata-rata Nilai Matkul (50%)
                            <span class="fw-bold">{{ number_format($avgIndividu['proyek'], 1) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Rata-rata Presentasi Individu (20%)
                            <span class="fw-bold">{{ number_format($avgIndividu['presentasi'], 1) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Nilai Teman Sejawat (30%)
                            <span class="fw-bold">{{ number_format($skorSejawat, 1) }} <small class="text-muted fw-normal">({{ number_format($avgRatingSejawat, 1) }}/5.0)</small></span>
                        </li>
                    </ul>

                    @php
                        // Hitung Skor Akhir Mahasiswa (SAW)
                        $skorAkhir = ($avgIndividu['proyek'] * 0.50) + 
                                     ($avgIndividu['presentasi'] * 0.20) + 
                                     ($skorSejawat * 0.30);
                    @endphp

                    <div class="alert alert-warning mt-3 text-center mb-0">
                        <h3 class="fw-bold mb-0">{{ number_format($skorAkhir, 2) }}</h3>
                        <small>Skor ini digunakan untuk penentuan Ranking Mahasiswa Terbaik</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection