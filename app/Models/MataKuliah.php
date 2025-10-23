<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    // Izinkan kolom ini untuk diisi secara massal
    protected $fillable = ['kode_mk', 'nama_mk', 'sks'];
    public function dosens()
    {
    return $this->belongsToMany(User::class, 'dosen_matakuliah', 'mata_kuliah_id', 'user_id');
    }
    public function pengumpulans()
    {
    return $this->hasMany(Pengumpulan::class);
    }
}