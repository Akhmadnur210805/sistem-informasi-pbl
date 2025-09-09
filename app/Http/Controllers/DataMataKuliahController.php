<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DataMataKuliahController extends Controller
{
    public function index(): View
    {
        $mataKuliahs = MataKuliah::all();
        return view('admin.matakuliah.index', compact('mataKuliahs'));
    }

    public function create(): View
    {
        return view('admin.matakuliah.create');
    }

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

    public function edit(MataKuliah $matakuliah): View
    {
        return view('admin.matakuliah.edit', ['matakuliah' => $matakuliah]);
    }

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

    public function destroy(MataKuliah $matakuliah): RedirectResponse
    {
        $matakuliah->delete();
        return redirect()->route('admin.matakuliah.index')->with('success', 'Mata Kuliah berhasil dihapus.');
    }
}