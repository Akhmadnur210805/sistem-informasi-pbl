<?php

namespace App\Imports;

use App\Models\User;
use App\Models\MataKuliah;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Ambil semua NIP unik dari file Excel untuk diproses
        $uniqueNips = $rows->pluck('nip')->unique();

        // 1. Hapus semua penugasan LAMA untuk dosen yang ada di file Excel
        // Ini memastikan data yang diimpor adalah data yang paling update.
        User::whereIn('kode_admin', $uniqueNips)->where('role', 'dosen')->each(function ($dosen) {
            $dosen->mataKuliahs()->detach();
        });

        // 2. Loop melalui setiap baris di Excel untuk membuat/memperbarui data
        foreach ($rows as $row) {
            // Validasi sederhana untuk memastikan baris tidak kosong
            if (empty($row['nip']) || empty($row['kode_mk'])) {
                continue; // Lewati baris jika NIP atau Kode MK kosong
            }

            // Cari atau buat Dosen baru berdasarkan NIP
            $dosen = User::updateOrCreate(
                ['kode_admin' => $row['nip']],
                [
                    'name' => $row['nama'],
                    'email' => $row['email'],
                    'password' => Hash::make($row['password']),
                    'role' => 'dosen',
                ]
            );

            // Cari Mata Kuliah berdasarkan kode_mk
            $matakuliah = MataKuliah::where('kode_mk', $row['kode_mk'])->first();

            // Jika mata kuliah dan dosen valid, tambahkan penugasan baru
            if ($dosen && $matakuliah) {
                $dosen->mataKuliahs()->attach($matakuliah->id, [
                    'periode' => strtolower($row['periode']), // pastikan 'sebelum_uts' atau 'setelah_uts'
                    'kelas' => strtoupper($row['kelas']),     // Simpan kelas dalam huruf besar
                ]);
            }
        }
    }
}