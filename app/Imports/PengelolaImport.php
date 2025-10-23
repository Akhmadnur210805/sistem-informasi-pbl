<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PengelolaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Pastikan header di file Excel Anda adalah:
        // id_pengelola, nama, email, jenis_pengelola, password
        return new User([
            'kode_admin'      => $row['id_pengelola'],
            'name'            => $row['nama'],
            'email'           => $row['email'],
            'jenis_pengelola' => $row['jenis_pengelola'],
            'password'        => Hash::make($row['password']),
            'role'            => 'pengelola', // Role diisi otomatis
        ]);
    }
}