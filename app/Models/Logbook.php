<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'minggu_ke',
        'deskripsi',
        'file_path',
    ];

    /**
     * Relasi ke user (mahasiswa) yang membuat logbook.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}