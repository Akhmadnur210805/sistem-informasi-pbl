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
            // Relasi ke tabel users (Mustahik)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Relasi ke kategori bantuan
            $table->foreignId('kategori_bantuan_id')->constrained('kategori_bantuans')->onDelete('cascade');
            
            // Kode unik pengajuan (Contoh: BZ-20260225-001)
            $table->string('nomor_pengajuan')->unique();
            
            // Data isian form ekonomi
            $table->integer('penghasilan_bulanan');
            $table->integer('jumlah_tanggungan');
            $table->text('deskripsi_kondisi');
            
            // Kolom untuk upload file (KTP/KK/SKTM dalam satu PDF atau Gambar)
            $table->string('berkas_pendukung')->nullable();
            
            // Status pengajuan
            $table->enum('status', ['menunggu', 'diproses', 'disetujui', 'ditolak'])->default('menunggu');
            
            // Catatan dari petugas
            $table->text('pesan_petugas')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};