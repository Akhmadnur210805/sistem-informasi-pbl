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
    Schema::create('peer_reviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reviewer_id')->comment('ID Mahasiswa yang menilai')->constrained('users')->onDelete('cascade');
        $table->foreignId('reviewed_id')->comment('ID Mahasiswa yang dinilai')->constrained('users')->onDelete('cascade');
        $table->integer('minggu_ke');
        $table->tinyInteger('rating')->comment('Nilai dari 1-5');
        $table->text('komentar')->nullable();
        $table->timestamps();

        // Mencegah satu orang menilai teman yang sama lebih dari sekali di minggu yang sama
        $table->unique(['reviewer_id', 'reviewed_id', 'minggu_ke']);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peer_reviews');
    }
};
