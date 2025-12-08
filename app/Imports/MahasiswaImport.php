<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Pastikan file Excel Anda memiliki header:
        // nim, nama, email, kelas, kelompok, password
        // Penulisan header harus sama persis (disarankan huruf kecil semua).
        
        return new User([
            'kode_admin' => $row['nim'],
            'name'       => $row['nama'],
            'angkatan'   => $row['angkatan'],
            'email'      => $row['email'],
            'kelas'      => $row['kelas'],
            'kelompok'   => $row['kelompok'],
            'password'   => Hash::make($row['password']),
            'role'       => 'mahasiswa', // Role diisi secara otomatis
        ]);
    }
}