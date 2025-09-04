<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse; // <-- TAMBAHKAN INI

class DataMahasiswaController extends Controller
{
    /**
     * Menampilkan halaman daftar mahasiswa.
     */
    public function index(): View
    {
        $mahasiswas = User::where('role', 'mahasiswa')->get();
        return view('admin.mahasiswa.index', ['mahasiswas' => $mahasiswas]);
    }

    /**
     * Menampilkan formulir untuk membuat data mahasiswa baru.
     */
    public function create(): View
    {
        return view('admin.mahasiswa.create');
    }

    /**
     * Menyimpan data mahasiswa baru ke database.
     */
    public function store(Request $request): RedirectResponse // <-- Tambahkan return type
    {
        $request->validate([
            'kode_admin' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
            'kelas' => 'required|string|max:255',
            'kelompok' => 'required|string|max:255',
        ]);

        User::create([
            'kode_admin' => $request->kode_admin,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
            'kelas' => $request->kelas,
            'kelompok' => $request->kelompok,
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }
    
    /**
     * Menampilkan formulir untuk mengedit data mahasiswa.
     */
    public function edit(User $mahasiswa): View|RedirectResponse // <-- PERBAIKI DI SINI
    {
        if ($mahasiswa->role !== 'mahasiswa') {
            return redirect()->route('admin.mahasiswa.index')->with('error', 'Data yang dipilih bukan data mahasiswa.');
        }

        return view('admin.mahasiswa.edit', ['mahasiswa' => $mahasiswa]);
    }

    /**
     * Memperbarui data mahasiswa di database.
     */
    public function update(Request $request, User $mahasiswa): RedirectResponse // <-- Tambahkan return type
    {
        $request->validate([
            'kode_admin' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($mahasiswa->id)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($mahasiswa->id)],
            'password' => 'nullable|string|min:5',
            'kelas' => 'required|string|max:255',
            'kelompok' => 'required|string|max:255',
        ]);

        $dataToUpdate = [
            'kode_admin' => $request->kode_admin,
            'name' => $request->name,
            'email' => $request->email,
            'kelas' => $request->kelas,
            'kelompok' => $request->kelompok,
        ];

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $mahasiswa->update($dataToUpdate);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Menghapus data mahasiswa dari database.
     */
    public function destroy(User $mahasiswa): RedirectResponse // <-- Tambahkan return type
    {
        if ($mahasiswa->role !== 'mahasiswa') {
            return back()->with('error', 'Data yang dipilih bukan data mahasiswa.');
        }

        $mahasiswa->delete();

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}