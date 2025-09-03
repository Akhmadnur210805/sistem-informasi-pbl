<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'kode_admin' => 'admin01',
            'name' => 'Administrator',
            'email' => 'admin@example.com', // ikut tabel users bawaan Laravel
            'password' => Hash::make('12345'),
        ]);
    }
}
