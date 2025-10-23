<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeerReview extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reviewer_id',
        'reviewed_id',
        'minggu_ke',
        'rating',
        'komentar',
    ];

    /**
     * Mendapatkan data user (mahasiswa) yang memberikan penilaian.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Mendapatkan data user (mahasiswa) yang menerima penilaian.
     */
    public function reviewed()
    {
        return $this->belongsTo(User::class, 'reviewed_id');
    }
}