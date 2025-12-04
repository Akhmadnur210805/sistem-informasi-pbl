<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianKelompok extends Model
{
    use HasFactory;
    protected $table = 'penilaian_kelompok'; // Tentukan nama tabel
    protected $fillable = [
        'dosen_id',
        'kelas',
        'kelompok',
        'periode',
        'nilai_hasil_proyek',
        'nilai_kerja_sama',
        'nilai_presentasi_kelompok',
    ];
}