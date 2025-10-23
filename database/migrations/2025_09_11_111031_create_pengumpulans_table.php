<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('pengumpulans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mata_kuliah_id')->constrained()->onDelete('cascade');
            $table->string('nama_file');
            $table->string('path_file');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pengumpulans');
    }
};