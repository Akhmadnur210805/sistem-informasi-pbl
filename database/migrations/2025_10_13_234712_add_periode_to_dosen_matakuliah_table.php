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
    Schema::table('dosen_matakuliah', function (Blueprint $table) {
        // Menambahkan kolom periode setelah mata_kuliah_id
        $table->string('periode')->after('mata_kuliah_id')->default('sebelum_uts');
    });
}

public function down(): void
{
    Schema::table('dosen_matakuliah', function (Blueprint $table) {
        $table->dropColumn('periode');
    });
}
};
