<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    // 1. Agar Laravel tahu kolom mana saja yang boleh diisi manual
    protected $fillable = [
        'judul',
        'deskripsi',
        'deadline',
        'status',    // isinya: 'todo', 'process', 'done'
        'prioritas', // isinya: 'penting', 'biasa'
    ];

    // 2. Fitur Tambahan: Casting
    // Mengubah kolom 'deadline' otomatis menjadi format Tanggal (Carbon)
    // Supaya di View bisa langsung pakai format tanggal cantik (contoh: ->format('d M Y'))
    protected $casts = [
        'deadline' => 'date',
    ];
}