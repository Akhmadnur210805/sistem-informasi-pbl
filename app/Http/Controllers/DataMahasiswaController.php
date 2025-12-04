<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use App\Imports\MahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class DataMahasiswaController extends Controller
{
    /**
     * Menampilkan halaman daftar mahasiswa.
     */
    public function index(): View
    {
        // Query data mahasiswa, diurutkan dari angkatan terbaru, lalu kelas
        $mahasiswas = User::where('role', 'mahasiswa')
                          ->orderBy('angkatan', 'desc')
                          ->orderBy('kelas')
                          ->get();

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
     * Mengimpor data mahasiswa dari file Excel.
     */
    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new MahasiswaImport, $request->file('file_excel'));
        } catch (\Exception $e) {
            return back()->withErrors(['file_excel' => 'Terjadi kesalahan saat mengimpor file. Pastikan format file dan headernya benar. Error: ' . $e->getMessage()]);
        }

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil diimpor!');
    }

    /**
     * Menyimpan data mahasiswa baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kode_admin' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
            'angkatan' => 'required|numeric|digits:4', // Tambahkan Validasi Angkatan
            'kelas' => 'required|string|max:255',
            'kelompok' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) use ($request) {
                $count = User::where('kelas', $request->kelas)->where('kelompok', $value)->count();
                if ($count >= 5) {
                    $fail('Kelompok ' . $value . ' di kelas ' . $request->kelas . ' sudah penuh (Maksimal 5 anggota).');
                }
            }],
        ]);

        User::create([
            'kode_admin' => $request->kode_admin,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
            'angkatan' => $request->angkatan, // Simpan Angkatan
            'kelas' => $request->kelas,
            'kelompok' => $request->kelompok,
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit data mahasiswa.
     */
    public function edit(User $mahasiswa): View|RedirectResponse
    {
        if ($mahasiswa->role !== 'mahasiswa') {
            return redirect()->route('admin.mahasiswa.index')->with('error', 'Data yang dipilih bukan data mahasiswa.');
        }
        return view('admin.mahasiswa.edit', ['mahasiswa' => $mahasiswa]);
    }

    /**
     * Memperbarui data mahasiswa di database.
     */
    public function update(Request $request, User $mahasiswa): RedirectResponse
    {
        $request->validate([
            'kode_admin' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($mahasiswa->id)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($mahasiswa->id)],
            'password' => 'nullable|string|min:5',
            'angkatan' => 'required|numeric|digits:4', // Tambahkan Validasi Angkatan
            'kelas' => 'required|string|max:255',
            'kelompok' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) use ($request, $mahasiswa) {
                $count = User::where('kelas', $request->kelas)
                             ->where('kelompok', $value)
                             ->where('id', '!=', $mahasiswa->id)
                             ->count();
                if ($count >= 5) {
                    $fail('Kelompok ' . $value . ' di kelas ' . $request->kelas . ' sudah penuh (Maksimal 5 anggota).');
                }
            }],
        ]);

        $dataToUpdate = [
            'kode_admin' => $request->kode_admin,
            'name' => $request->name,
            'email' => $request->email,
            'angkatan' => $request->angkatan, // Update Angkatan
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
    public function destroy(User $mahasiswa): RedirectResponse
    {
        if ($mahasiswa->role !== 'mahasiswa') {
            return back()->with('error', 'Data yang dipilih bukan data mahasiswa.');
        }

        $mahasiswa->delete();

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}