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
        // Menambahkan kolom file yang dibutuhkan
        $table->string('file_ktp')->after('deskripsi_kondisi');
        $table->string('file_kk')->after('file_ktp');
        $table->string('file_sktm')->nullable()->after('file_kk');
        $table->string('file_pendukung')->nullable()->after('file_sktm');
    });
}

public function down(): void
{
    Schema::table('pengajuans', function (Blueprint $table) {
        $table->dropColumn(['file_ktp', 'file_kk', 'file_sktm', 'file_pendukung']);
    });
}
};
