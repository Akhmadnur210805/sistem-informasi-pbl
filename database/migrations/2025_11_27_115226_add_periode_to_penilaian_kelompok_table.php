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
    Schema::table('penilaian_kelompok', function (Blueprint $table) {
        $table->string('periode')->default('sebelum_uts')->after('kelompok');
        // Kita hapus unique key lama dan buat yang baru termasuk periode
        $table->dropUnique(['kelas', 'kelompok']); 
        $table->unique(['kelas', 'kelompok', 'periode']); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_kelompok', function (Blueprint $table) {
            //
        });
    }
};
