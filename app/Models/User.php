<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi (Mass Assignable).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'google_token',
        'google_refresh_token',
        'nik',
        'no_hp',
        'alamat',
        'role',
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * --- RELASI DATABASE ---
     */

    /**
     * Relasi ke model Pengajuan.
     * Satu User (Mustahik) bisa memiliki banyak Pengajuan bantuan.
     * Ini sangat penting agar 'withCount(pengajuans)' di PetugasController berfungsi.
     */
    public function pengajuans(): HasMany
    {
        return $this->hasMany(Pengajuan::class, 'user_id');
    }

    /**
     * --- HELPER METHODS ---
     */

    /**
     * Mengecek apakah user adalah Petugas
     */
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    /**
     * Mengecek apakah user adalah Mustahik
     */
    public function isMustahik(): bool
    {
        return $this->role === 'mustahik';
    }
}