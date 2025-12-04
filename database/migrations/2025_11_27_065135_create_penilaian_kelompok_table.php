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
    Schema::create('penilaian_kelompok', function (Blueprint $table) {
        $table->id();
        $table->foreignId('dosen_id')->constrained('users');
        $table->string('kelas');
        $table->string('kelompok');
        $table->integer('nilai_hasil_proyek')->nullable();
        $table->integer('nilai_kerja_sama')->nullable();
        $table->integer('nilai_presentasi_kelompok')->nullable();
        $table->timestamps();

        // Kunci unik agar satu kelompok di satu kelas tidak bisa dinilai dua kali
        $table->unique(['kelas', 'kelompok']);
    });
}
};
