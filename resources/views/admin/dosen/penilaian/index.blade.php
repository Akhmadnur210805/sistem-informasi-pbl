@foreach (Auth::user()->mataKuliahs as $penugasan)
    <a href="{{ route('dosen.penilaian.form', ['matakuliah' => $penugasan->id, 'kelas' => $penugasan->pivot->kelas]) }}">
        Nilai {{ $penugasan->nama_mk }} - Kelas {{ $penugasan->pivot->kelas }}
    </a>
@endforeach