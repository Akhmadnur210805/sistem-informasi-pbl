<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBantuan; 

class KategoriBantuanController extends Controller
{
    // Tampil Daftar Tabel
    public function index()
    {
        $kategori = KategoriBantuan::all(); 
        return view('petugas.kategori_bantuan.index', compact('kategori'));
    }

    // Tampil Form Tambah
    public function create()
    {
        return view('petugas.kategori_bantuan.create');
    }

    // Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_bantuan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriBantuan::create([
            'nama_bantuan' => $request->nama_bantuan,
            'deskripsi' => $request->deskripsi,
            'is_active' => true,
        ]);

        return redirect()->route('petugas.kategori.index')->with('success', 'Kategori bantuan berhasil ditambahkan!');
    }

    // Tampil Form Edit
    public function edit($id)
    {
        $kategori = KategoriBantuan::findOrFail($id);
        return view('petugas.kategori_bantuan.edit', compact('kategori'));
    }

    // Proses Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bantuan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $kategori = KategoriBantuan::findOrFail($id);
        $kategori->update([
            'nama_bantuan' => $request->nama_bantuan,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('petugas.kategori.index')->with('success', 'Kategori bantuan berhasil diperbarui!');
    }

    // Proses Hapus Data
    public function destroy($id)
    {
        $kategori = KategoriBantuan::findOrFail($id);
        $kategori->delete();

        return redirect()->route('petugas.kategori.index')->with('success', 'Kategori bantuan berhasil dihapus!');
    }
}