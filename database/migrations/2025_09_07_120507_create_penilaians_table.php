<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID Mahasiswa
            $table->foreignId('mata_kuliah_id')->constrained()->onDelete('cascade'); // ID Mata Kuliah
            $table->unsignedInteger('nilai');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('penilaians');
    }
};