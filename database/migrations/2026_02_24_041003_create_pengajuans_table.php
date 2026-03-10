<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            
            // Relasi
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_bantuan_id')->constrained('kategori_bantuans')->onDelete('cascade');
            
            // Data Utama
            $table->string('nomor_pengajuan')->unique();
            $table->string('nama_lengkap')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat_ktp')->nullable();
            $table->string('penghasilan_bulanan')->nullable();
            $table->integer('jumlah_tanggungan')->nullable()->default(0);
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('titik_koordinat')->nullable();
            $table->text('deskripsi_kondisi')->nullable();
            
            // Kolom File (WAJIB NULLABLE agar form yang tidak mewajibkan KK/SKTM tidak error database)
            $table->string('pas_foto')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_sktm')->nullable();
            $table->string('file_pendukung')->nullable();
            
            // Status & Catatan Petugas
            $table->enum('status', ['menunggu', 'diproses', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('pesan_petugas')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};