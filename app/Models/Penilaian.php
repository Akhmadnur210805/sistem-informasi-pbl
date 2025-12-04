<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mata_kuliah_id',
        'periode',
        'nilai',
        'nilai_presentasi'
    ];

    /**
     * Relasi ke tabel Mata Kuliah.
     * (Fungsi inilah yang dicari oleh Controller tapi tidak ketemu sebelumnya)
     */
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    /**
     * Relasi ke tabel User (Mahasiswa).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}