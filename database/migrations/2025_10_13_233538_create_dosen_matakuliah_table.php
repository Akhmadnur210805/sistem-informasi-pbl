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
    Schema::create('dosen_matakuliah', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->onDelete('cascade');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('dosen_matakuliah');
    }
};
