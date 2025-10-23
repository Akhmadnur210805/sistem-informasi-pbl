<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Imports\MataKuliahImport;     // <-- Tambahkan ini
use Maatwebsite\Excel\Facades\Excel; // <-- Tambahkan ini

class DataMataKuliahController extends Controller
{
    /**
     * Menampilkan halaman daftar mata kuliah.
     */
    public function index(): View
    {
        $mataKuliahs = MataKuliah::all();
        return view('admin.matakuliah.index', compact('mataKuliahs'));
    }

    /**
     * Menampilkan form untuk membuat mata kuliah baru.
     */
    public function create(): View
    {
        return view('admin.matakuliah.create');
    }

    /**
     * Menyimpan mata kuliah baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kode_mk' => 'required|string|unique:mata_kuliahs|max:255',
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer',
        ]);

        MataKuliah::create($request->all());

        return redirect()->route('admin.matakuliah.index')->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    /**
     * Mengimpor data mata kuliah dari file Excel.
     */
    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new MataKuliahImport, $request->file('file_excel'));
        } catch (\Exception $e) {
            return back()->withErrors(['file_excel' => 'Gagal mengimpor data. Pastikan format file dan header Anda benar. Error: ' . $e->getMessage()]);
        }

        return redirect()->route('admin.matakuliah.index')->with('success', 'Data mata kuliah berhasil diimpor!');
    }

    /**
     * Menampilkan form untuk mengedit mata kuliah.
     */
    public function edit(MataKuliah $matakuliah): View
    {
        return view('admin.matakuliah.edit', ['matakuliah' => $matakuliah]);
    }

    /**
     * Memperbarui mata kuliah di database.
     */
    public function update(Request $request, MataKuliah $matakuliah): RedirectResponse
    {
        $request->validate([
            'kode_mk' => 'required|string|max:255|unique:mata_kuliahs,kode_mk,' . $matakuliah->id,
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer',
        ]);

        $matakuliah->update($request->all());

        return redirect()->route('admin.matakuliah.index')->with('success', 'Mata Kuliah berhasil diperbarui.');
    }

    /**
     * Menghapus mata kuliah dari database.
     */
    public function destroy(MataKuliah $matakuliah): RedirectResponse
    {
        $matakuliah->delete();
        return redirect()->route('admin.matakuliah.index')->with('success', 'Mata Kuliah berhasil dihapus.');
    }
}