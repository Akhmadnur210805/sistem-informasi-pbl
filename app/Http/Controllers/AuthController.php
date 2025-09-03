<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
{
    // Validasi input
    $credentials = $request->validate([
        'kode_admin' => ['required'],
        'password' => ['required'],
    ]);

    // Coba login dengan kredensial yang diberikan
    // Asumsi: 'username' adalah nama kolom untuk menyimpan NIM/NIP/kode di database
    if (Auth::attempt(['username' => $credentials['kode_admin'], 'password' => $credentials['password']])) {
        $request->session()->regenerate();

        // Ambil data pengguna yang berhasil login
        $user = Auth::user();

        // Cek role pengguna dan arahkan ke dashboard yang sesuai
        if ($user->role == 'admin') {
            return redirect()->intended('/dashboard_admin');
        } elseif ($user->role == 'dosen') {
            return redirect()->intended('/dashboard_dosen');
        } elseif ($user->role == 'mahasiswa') {
            return redirect()->intended('/dashboard_mahasiswa');
        } elseif ($user->role == 'pengelola') {
            return redirect()->intended('/dashboard_pengelola');
        }
    }

    // Jika gagal login
    return back()->withErrors([
        'kode_admin' => 'Kode atau kata sandi salah!',
    ])->onlyInput('kode_admin');
}
}
