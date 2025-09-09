<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    // Izinkan kolom ini untuk diisi secara massal
    protected $fillable = ['kode_mk', 'nama_mk', 'sks'];
}