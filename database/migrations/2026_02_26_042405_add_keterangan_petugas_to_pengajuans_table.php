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
        // Menambahkan kolom untuk menyimpan alasan setuju/tolak petugas
        $table->text('keterangan_petugas')->nullable()->after('status');
    });
}

public function down(): void
{
    Schema::table('pengajuans', function (Blueprint $table) {
        $table->dropColumn('keterangan_petugas');
    });
}
};
