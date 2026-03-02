<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Akun Petugas Pertama
        User::create([
            'name' => 'Admin BAZNAS',
            'email' => 'petugas@baznas.com',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
        ]);

        // Membuat Akun Pimpinan Pertama
        User::create([
            'name' => 'Ketua BAZNAS',
            'email' => 'pimpinan@baznas.com',
            'password' => Hash::make('password123'),
            'role' => 'pimpinan',
        ]);
        
        // Anda bisa menambah banyak akun di sini
    }
}