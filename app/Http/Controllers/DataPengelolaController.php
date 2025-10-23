<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use App\Imports\PengelolaImport;      // <-- Tambahkan ini
use Maatwebsite\Excel\Facades\Excel;  // <-- Tambahkan ini

class DataPengelolaController extends Controller
{
    /**
     * Menampilkan halaman daftar pengelola.
     */
    public function index(): View
    {
        $pengelolas = User::where('role', 'pengelola')->get();
        return view('admin.pengelola.index', ['pengelolas' => $pengelolas]);
    }

    /**
     * Menampilkan form untuk membuat data pengelola baru.
     */
    public function create(): View
    {
        return view('admin.pengelola.create');
    }

    /**
     * Menyimpan data pengelola baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kode_admin' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
            'jenis_pengelola' => 'required|string',
        ]);

        User::create([
            'kode_admin' => $request->kode_admin,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengelola',
            'jenis_pengelola' => $request->jenis_pengelola,
        ]);

        return redirect()->route('admin.pengelola.index')->with('success', 'Data pengelola berhasil ditambahkan.');
    }

    /**
     * Mengimpor data pengelola dari file Excel.
     */
    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new PengelolaImport, $request->file('file_excel'));
        } catch (\Exception $e) {
            return back()->withErrors(['file_excel' => 'Gagal mengimpor data. Pastikan format file dan header Anda benar. Error: ' . $e->getMessage()]);
        }

        return redirect()->route('admin.pengelola.index')->with('success', 'Data pengelola berhasil diimpor!');
    }

    /**
     * Menampilkan form untuk mengedit data pengelola.
     */
    public function edit(User $pengelola): View|RedirectResponse
    {
        if ($pengelola->role !== 'pengelola') {
            return redirect()->route('admin.pengelola.index')->with('error', 'Data yang dipilih bukan data pengelola.');
        }
        return view('admin.pengelola.edit', ['pengelola' => $pengelola]);
    }

    /**
     * Memperbarui data pengelola di database.
     */
    public function update(Request $request, User $pengelola): RedirectResponse
    {
        $request->validate([
            'kode_admin' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($pengelola->id)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($pengelola->id)],
            'password' => 'nullable|string|min:5',
            'jenis_pengelola' => 'required|string',
        ]);

        $dataToUpdate = [
            'kode_admin' => $request->kode_admin,
            'name' => $request->name,
            'email' => $request->email,
            'jenis_pengelola' => $request->jenis_pengelola,
        ];

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $pengelola->update($dataToUpdate);

        return redirect()->route('admin.pengelola.index')->with('success', 'Data pengelola berhasil diperbarui.');
    }

    /**
     * Menghapus data pengelola dari database.
     */
    public function destroy(User $pengelola): RedirectResponse
    {
        if ($pengelola->role !== 'pengelola') {
            return back()->with('error', 'Data yang dipilih bukan data pengelola.');
        }

        $pengelola->delete();

        return redirect()->route('admin.pengelola.index')->with('success', 'Data pengelola berhasil dihapus.');
    }
}