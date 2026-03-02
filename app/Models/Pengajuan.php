<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengajuan extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'pengajuans';

    // Kolom yang boleh diisi (Mass Assignable)
    protected $fillable = [
        'user_id', 
        'kategori_bantuan_id', 
        'nomor_pengajuan',
        // Data Identitas Sesuai KTP
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_ktp',
        // Data Ekonomi & Profil
        'penghasilan_bulanan', 
        'jumlah_tanggungan', 
        'pendidikan_terakhir', 
        'pekerjaan', 
        'titik_koordinat',
        'deskripsi_kondisi', 
        // File & Berkas
        'pas_foto', 
        'file_ktp', 
        'file_kk', 
        'file_sktm', 
        'file_pendukung', // Digunakan untuk foto rumah/berkas tambahan
        // Status & Admin
        'status', 
        'keterangan_petugas'
    ];

    /**
     * Casting tipe data agar Laravel mengenali formatnya secara otomatis.
     * Ini mencegah error saat menampilkan tanggal atau menghitung angka.
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'penghasilan_bulanan' => 'integer',
        'jumlah_tanggungan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke User (Mustahik)
     * Menghubungkan pengajuan ke akun yang mengajukan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Kategori Bantuan
     * Menghubungkan pengajuan ke jenis bantuan (Misal: Zakat Fitrah, Bedah Rumah).
     */
    public function kategoriBantuan(): BelongsTo
    {
        return $this->belongsTo(KategoriBantuan::class, 'kategori_bantuan_id');
    }

    /**
     * Helper untuk mengecek status dengan cepat di View
     */
    public function isMenunggu(): bool
    {
        return $this->status === 'menunggu';
    }

    public function isDisetujui(): bool
    {
        return $this->status === 'disetujui';
    }

    public function isDitolak(): bool
    {
        return $this->status === 'ditolak';
    }
}