<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengajuan_id',
        'jenis_dokumen',
        'file_path',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }
}