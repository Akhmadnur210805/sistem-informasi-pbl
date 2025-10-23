<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil AdminSeeder untuk membuat user admin
        $this->call([
            AdminSeeder::class,
        ]);
    }
}