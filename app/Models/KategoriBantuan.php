<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBantuan extends Model
{
    use HasFactory;

    protected $table = 'kategori_bantuans';

    // Tambahkan 'jenis_form' ke dalam array ini
    protected $fillable = [
        'nama_bantuan',
        'deskripsi',
        'jenis_form', // <--- INI YANG BARU DITAMBAHKAN
        'is_active',
    ];

    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }
}