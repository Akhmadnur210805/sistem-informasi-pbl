@extends('layout_mahasiswa.app')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h3 class="m-0 fw-bold">Dashboard Project</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    
    {{-- ALERT SYSTEM --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- WELCOME BANNER --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="background: linear-gradient(120deg, #1e3c72 0%, #2a5298 100%); color: white; border-radius: 12px;">
                <div class="card-body p-4">
                    <h2 class="fw-bold"><i class="bi bi-kanban me-2"></i>Papan Kerja: {{ Auth::user()->name }}</h2>
                    <p class="mb-0 opacity-75">
                        Anda memiliki <strong>{{ $todo->count() + $process->count() }}</strong> tugas aktif. Tetap semangat!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        
        {{-- KOLOM KIRI: MENU & STATUS --}}
        <div class="col-lg-3 mb-4">
            {{-- Status Logbook --}}
            <div class="card shadow-sm border-0 mb-3 text-center">
                <div class="card-body py-4">
                    <h6 class="fw-bold text-muted mb-3">LOGBOOK MINGGU INI</h6>
                    
                    @if($totalLogbook > 50) {{-- LOGIKA DUMMY (Sesuaikan dengan logic Anda) --}}
                        <div class="btn btn-success btn-circle btn-lg mb-2 shadow-sm" style="width: 60px; height: 60px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bi bi-check-lg fs-1"></i>
                        </div>
                        <h5 class="fw-bold text-success">Terkirim</h5>
                    @else
                        <div class="position-relative d-inline-block mb-3">
                            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
                        </div>
                        <h5 class="fw-bold text-primary mb-3">Sedang Proses</h5>
                        {{-- HAPUS: Keterangan Sisa Hari --}}
                        <a href="{{ route('mahasiswa.logbook.index') }}" class="btn btn-primary btn-sm w-100 rounded-pill">Isi Sekarang</a>
                    @endif
                </div>
            </div>

            {{-- Menu Shortcut (Fitur Cepat) --}}
            <div class="list-group shadow-sm border-0">
                <a href="{{ route('mahasiswa.nilai.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                    <div><i class="bi bi-award text-warning me-2"></i> Nilai Studi</div>
                    {{-- HAPUS: Badge Angka Total Nilai --}}
                    <i class="bi bi-chevron-right text-muted small"></i>
                </a>
                <a href="{{ route('mahasiswa.ranking.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                    <div><i class="bi bi-trophy text-danger me-2"></i> Skor Saya</div>
                    {{-- HAPUS: Angka Skor --}}
                    <i class="bi bi-chevron-right text-muted small"></i>
                </a>
            </div>
        </div>

        {{-- KOLOM KANAN: KANBAN BOARD --}}
        <div class="col-lg-9">
            
            {{-- Header & Tombol Tambah --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold m-0"><i class="bi bi-layout-three-columns me-2"></i>Aktivitas Proyek</h5>
                <button class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAgenda">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Tugas
                </button>
            </div>

            <div class="row g-3">
                
                {{-- 1. KOLOM RENCANA (TODO) --}}
                <div class="col-md-4">
                    <div class="card bg-light border-0 h-100 rounded-3">
                        <div class="card-header bg-transparent fw-bold text-secondary border-0 d-flex justify-content-between">
                            <span><i class="bi bi-circle me-1"></i> RENCANA</span>
                            <span class="badge bg-secondary rounded-pill">{{ $todo->count() }}</span>
                        </div>
                        <div class="card-body p-2 custom-scrollbar" style="max-height: 500px; overflow-y: auto;">
                            
                            @forelse($todo as $item)
                                <div class="card border-0 shadow-sm mb-2 kanban-card">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="badge {{ $item->prioritas == 'penting' ? 'bg-danger' : 'bg-secondary' }}" style="font-size: 10px;">
                                                {{ strtoupper($item->prioritas) }}
                                            </span>
                                            
                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('mahasiswa.agenda.delete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus rencana ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link text-muted p-0" style="font-size: 12px;"><i class="bi bi-x-lg"></i></button>
                                            </form>
                                        </div>

                                        <h6 class="fw-bold text-dark mb-1">{{ $item->judul }}</h6>
                                        <p class="small text-muted mb-3">{{ Str::limit($item->deskripsi, 40) }}</p>

                                        {{-- Tombol Geser ke Proses --}}
                                        <form action="{{ route('mahasiswa.agenda.updateStatus', $item->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="process">
                                            <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                                <i class="bi bi-arrow-right-circle me-1"></i> Kerjakan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted opacity-50">
                                    <i class="bi bi-clipboard fs-2 mb-2"></i>
                                    <p class="small mb-0">Belum ada rencana</p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>

                {{-- 2. KOLOM PROSES (PROCESS) --}}
                <div class="col-md-4">
                    <div class="card border-0 h-100 rounded-3" style="background-color: #ebf5ff;"> 
                        <div class="card-header bg-transparent fw-bold text-primary border-0 d-flex justify-content-between">
                            <span><i class="bi bi-arrow-repeat me-1 spin-icon"></i> PROSES</span>
                            <span class="badge bg-primary rounded-pill">{{ $process->count() }}</span>
                        </div>
                        <div class="card-body p-2 custom-scrollbar" style="max-height: 500px; overflow-y: auto;">
                            
                            @forelse($process as $item)
                                <div class="card border-0 shadow-sm mb-2 kanban-card border-start border-4 border-primary">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="badge bg-primary">ON GOING</span>
                                            @if($item->deadline)
                                                <small class="text-dark fw-bold" style="font-size: 10px;">
                                                    <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($item->deadline)->format('d M') }}
                                                </small>
                                            @endif
                                        </div>

                                        <h6 class="fw-bold text-dark mb-2">{{ $item->judul }}</h6>
                                        
                                        {{-- Tombol Geser ke Selesai --}}
                                        <form action="{{ route('mahasiswa.agenda.updateStatus', $item->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="done">
                                            <button type="submit" class="btn btn-success btn-sm w-100 text-white mb-2 shadow-sm">
                                                <i class="bi bi-check-lg me-1"></i> Selesai
                                            </button>
                                        </form>
                                        
                                        {{-- Tombol Batal --}}
                                        <form action="{{ route('mahasiswa.agenda.updateStatus', $item->id) }}" method="POST" class="text-center">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="todo">
                                            <button type="submit" class="btn btn-link btn-sm text-muted p-0 text-decoration-none" style="font-size: 11px;">
                                                Batal
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted opacity-50">
                                    <i class="bi bi-bicycle fs-2 mb-2"></i>
                                    <p class="small mb-0">Kosong</p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>

                {{-- 3. KOLOM SELESAI (DONE) --}}
                <div class="col-md-4">
                    <div class="card border-0 h-100 rounded-3" style="background-color: #f0fff4;">
                        <div class="card-header bg-transparent fw-bold text-success border-0 d-flex justify-content-between">
                            <span><i class="bi bi-check-circle-fill me-1"></i> SELESAI</span>
                            <span class="badge bg-success rounded-pill">{{ $done->count() }}</span>
                        </div>
                        <div class="card-body p-2 custom-scrollbar" style="max-height: 500px; overflow-y: auto;">
                            
                            @forelse($done as $item)
                                <div class="card border-0 shadow-sm mb-2 kanban-card opacity-75">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-bold text-muted text-decoration-line-through mb-1">{{ $item->judul }}</h6>
                                            {{-- Hapus Permanen --}}
                                            <form action="{{ route('mahasiswa.agenda.delete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus histori ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                        <small class="text-success d-block mt-1"><i class="bi bi-check-all"></i> Selesai</small>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted opacity-50">
                                    <i class="bi bi-archive fs-2 mb-2"></i>
                                    <p class="small mb-0">Kosong</p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH AGENDA --}}
    <div class="modal fade" id="modalTambahAgenda" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Tugas Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('mahasiswa.agenda.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Tugas</label>
                            <input type="text" name="judul" class="form-control" placeholder="Contoh: Buat ERD Database" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Detail tugas..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Deadline</label>
                                <input type="date" name="deadline" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Prioritas</label>
                                <select name="prioritas" class="form-select">
                                    <option value="biasa">Biasa</option>
                                    <option value="penting">Penting / Mendesak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- CSS CUSTOM --}}
    <style>
        .kanban-card { transition: transform 0.2s, box-shadow 0.2s; cursor: default; }
        .kanban-card:hover { transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important; }
        .spin-icon { animation: spin 4s linear infinite; display: inline-block; }
        @keyframes spin { 100% { transform:rotate(360deg); } }
        /* Scrollbar Halus */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #a0aec0; }
    </style>

@endsection