<?php

namespace App\Imports;

use App\Models\MataKuliah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MataKuliahImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Pastikan header di file Excel Anda adalah:
        // kode_mk, nama_mk, sks
        return new MataKuliah([
            'kode_mk' => $row['kode_mk'],
            'nama_mk' => $row['nama_mk'],
            'sks'     => $row['sks'],
        ]);
    }
}