<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('pengajuans', function (Blueprint $table) {
        $table->string('pas_foto')->nullable(); // Untuk foto 3x4
        $table->string('pendidikan_terakhir')->nullable();
        $table->string('pekerjaan')->nullable();
        $table->string('titik_koordinat')->nullable(); // Inovasi lokasi
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            //
        });
    }
};
