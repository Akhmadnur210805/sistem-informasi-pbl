<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBantuan extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit (opsional tapi aman)
    protected $table = 'kategori_bantuans';

    // Mengizinkan field ini untuk diisi melalui form
    protected $fillable = [
        'nama_bantuan',
        'deskripsi',
        'is_active',
    ];
}