<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use App\Imports\DosenImport;
use Maatwebsite\Excel\Facades\Excel;

class DataDosenController extends Controller
{
    /**
     * Menampilkan daftar dosen beserta penugasannya.
     */
    public function index(): View
    {
        $dosens = User::where('role', 'dosen')
                      ->with('mataKuliahSebelumUts', 'mataKuliahSetelahUts')
                      ->get();
        return view('admin.dosen.index', ['dosens' => $dosens]);
    }

    /**
     * Menampilkan form untuk menambah dosen baru.
     */
    public function create(): View
    {
        $mataKuliahs = MataKuliah::orderBy('nama_mk')->get();
        return view('admin.dosen.create', ['mataKuliahs' => $mataKuliahs]);
    }

    /**
     * Menyimpan data dosen baru dan penugasannya.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kode_admin' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
            'assignments' => 'nullable|array',
            'assignments.*.matakuliah_id' => 'required|exists:mata_kuliahs,id',
            'assignments.*.periode' => 'required|in:sebelum_uts,setelah_uts',
            'assignments.*.kelas' => 'required|string|max:10',
        ]);

        $dosen = User::create([
            'kode_admin' => $request->kode_admin,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen',
        ]);

        if ($request->has('assignments')) {
            foreach ($request->assignments as $assignment) {
                if (!empty($assignment['matakuliah_id'])) {
                    $dosen->mataKuliahs()->attach($assignment['matakuliah_id'], [
                        'periode' => $assignment['periode'],
                        // PERBAIKAN: Membersihkan data kelas sebelum disimpan
                        'kelas' => trim(strtoupper($assignment['kelas'])),
                    ]);
                }
            }
        }

        return redirect()->route('admin.dosen.index')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    /**
     * Mengimpor data dosen dari file Excel.
     */
    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls,csv']);

        DB::beginTransaction();
        try {
            Excel::import(new DosenImport, $request->file('file_excel'));
            DB::commit();
            return redirect()->route('admin.dosen.index')->with('success', 'Data dosen berhasil diimpor!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['file_excel' => 'Gagal mengimpor data. Pastikan format file benar dan semua Kode MK ada di sistem. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Menampilkan form untuk mengedit data dosen.
     */
    public function edit(User $dosen): View
    {
        $mataKuliahs = MataKuliah::orderBy('nama_mk')->get();
        $dosen->load('mataKuliahs');

        return view('admin.dosen.edit', [
            'dosen' => $dosen,
            'mataKuliahs' => $mataKuliahs
        ]);
    }

    /**
     * Memperbarui data dosen dan penugasannya.
     */
    public function update(Request $request, User $dosen): RedirectResponse
    {
        $request->validate([
            'kode_admin' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($dosen->id)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($dosen->id)],
            'password' => 'nullable|string|min:5',
            'assignments' => 'nullable|array',
            'assignments.*.matakuliah_id' => 'required_with:assignments|exists:mata_kuliahs,id',
            'assignments.*.periode' => 'required_with:assignments|in:sebelum_uts,setelah_uts',
            'assignments.*.kelas' => 'required_with:assignments|string|max:10',
        ]);

        $dosen->update($request->only('kode_admin', 'name', 'email'));
        if ($request->filled('password')) {
            $dosen->update(['password' => Hash::make($request->password)]);
        }

        // PERBAIKAN: Logika update yang lebih aman dan bersih
        // 1. Hapus semua penugasan lama
        $dosen->mataKuliahs()->detach();

        // 2. Tambahkan kembali semua penugasan baru dari form
        if ($request->has('assignments')) {
            foreach ($request->assignments as $assignment) {
                if (!empty($assignment['matakuliah_id'])) {
                    $dosen->mataKuliahs()->attach($assignment['matakuliah_id'], [
                        'periode' => $assignment['periode'],
                        // Membersihkan data kelas sebelum disimpan
                        'kelas' => trim(strtoupper($assignment['kelas'])),
                    ]);
                }
            }
        }

        return redirect()->route('admin.dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    /**
     * Menghapus data dosen dari database.
     */
    public function destroy(User $dosen): RedirectResponse
    {
        $dosen->delete();
        return redirect()->route('admin.dosen.index')->with('success', 'Data dosen berhasil dihapus.');
    }
}