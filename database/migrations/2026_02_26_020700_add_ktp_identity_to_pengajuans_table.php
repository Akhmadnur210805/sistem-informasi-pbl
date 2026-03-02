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
        // Menambahkan kolom identitas KTP
        $table->string('nama_lengkap')->after('nomor_pengajuan');
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->after('nama_lengkap');
        $table->string('tempat_lahir')->after('jenis_kelamin');
        $table->date('tanggal_lahir')->after('tempat_lahir');
        $table->text('alamat_ktp')->after('tanggal_lahir');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            //
        });
    }
};
