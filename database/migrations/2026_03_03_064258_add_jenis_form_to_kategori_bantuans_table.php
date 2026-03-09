<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategori_bantuans', function (Blueprint $table) {
            // Menambahkan kolom jenis_form setelah kolom deskripsi
            $table->string('jenis_form')->default('umum')->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('kategori_bantuans', function (Blueprint $table) {
            $table->dropColumn('jenis_form');
        });
    }
};