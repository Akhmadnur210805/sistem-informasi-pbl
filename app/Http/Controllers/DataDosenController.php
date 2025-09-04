<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class DataDosenController extends Controller
{
    public function index(): View
    {
        $dosens = User::where('role', 'dosen')->get();
        return view('admin.dosen.index', ['dosens' => $dosens]);
    }

    public function create(): View
    {
        return view('admin.dosen.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kode_admin' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
        ]);

        User::create([
            'kode_admin' => $request->kode_admin,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen',
        ]);

        return redirect()->route('admin.dosen.index')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function edit(User $dosen): View|RedirectResponse
    {
        if ($dosen->role !== 'dosen') {
            return redirect()->route('admin.dosen.index')->with('error', 'Data yang dipilih bukan data dosen.');
        }

        return view('admin.dosen.edit', ['dosen' => $dosen]);
    }

    public function update(Request $request, User $dosen): RedirectResponse
    {
        $request->validate([
            'kode_admin' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($dosen->id)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($dosen->id)],
            'password' => 'nullable|string|min:5',
        ]);

        $dataToUpdate = [
            'kode_admin' => $request->kode_admin,
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $dosen->update($dataToUpdate);

        return redirect()->route('admin.dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(User $dosen): RedirectResponse
    {
        if ($dosen->role !== 'dosen') {
            return back()->with('error', 'Data yang dipilih bukan data dosen.');
        }

        $dosen->delete();

        return redirect()->route('admin.dosen.index')->with('success', 'Data dosen berhasil dihapus.');
    }
}