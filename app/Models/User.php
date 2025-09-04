<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable; // Tambahkan HasFactory di sini

    protected $fillable = [
        'kode_admin',
        'name',
        'email',
        'password',
        'role',
        'kelas',    // <-- Tambahkan ini
        'kelompok', // <-- Tambahkan ini
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'kode_admin';
    }
}