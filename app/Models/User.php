<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Impor model yang dibutuhkan untuk relasi
use App\Models\MataKuliah;
use App\Models\Pengumpulan;
use App\Models\Logbook;
use App\Models\PeerReview;
use App\Models\Penilaian;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_admin',
        'name',
        'angkatan',
        'email',
        'password',
        'role',
        'kelas',
        'kelompok',
        'status', // Kolom ini mungkin sudah tidak relevan untuk dosen, tapi kita biarkan untuk role lain
        'jenis_pengelola',
        'google_id',
    ];

    /**
     * The attributes that are hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi dasar many-to-many ke MataKuliah.
     * Seorang Dosen bisa mengajar banyak Mata Kuliah di kelas yang spesifik.
     */
    public function mataKuliahs()
    {
        // Menyertakan 'periode' dan 'kelas' dari tabel pivot
        return $this->belongsToMany(MataKuliah::class, 'dosen_matakuliah', 'user_id', 'mata_kuliah_id')
                    ->withPivot('periode', 'kelas');
    }

    /**
     * Relasi HANYA ke mata kuliah SEBELUM UTS.
     */
    public function mataKuliahSebelumUts()
    {
        return $this->mataKuliahs()->wherePivot('periode', 'sebelum_uts');
    }

    /**
     * Relasi HANYA ke mata kuliah SETELAH UTS.
     */
    public function mataKuliahSetelahUts()
    {
        return $this->mataKuliahs()->wherePivot('periode', 'setelah_uts');
    }

    /**
     * Get the name of the unique identifier for the user for authentication.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        // Diubah untuk konsistensi dengan sistem login berbasis email
        return 'email';
    }

    /**
     * Define the relationship with Pengumpulan model.
     */
    public function pengumpulans()
    {
        return $this->hasMany(Pengumpulan::class);
    }

    /**
     * Mendapatkan semua logbook yang dibuat oleh user ini.
     */
    public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'user_id');
    }

    /**
     * Mendapatkan semua penilaian sejawat yang DITERIMA oleh user ini.
     */
    public function peerReviewsReceived()
    {
        return $this->hasMany(PeerReview::class, 'reviewed_id');
    }

    /**
     * BARU: Mendapatkan semua nilai mata kuliah yang DITERIMA oleh user ini.
     * (Relasi ini dibutuhkan oleh RankingController)
     */
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'user_id');
    }
}