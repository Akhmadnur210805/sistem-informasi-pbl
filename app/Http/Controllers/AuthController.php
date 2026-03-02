<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('login');
    }

    public function showRegister(): View
    {
        return view('register');
    }

    /**
     * Proses Login dengan Pengalihan Role yang Presisi
     */
    public function login(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Coba autentikasi
        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk keamanan (mencegah session fixation)
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // 3. Pengalihan berdasarkan role
            if ($user->role === 'petugas') {
                return redirect()->intended(route('petugas.dashboard'));
            }
            
            if ($user->role === 'pimpinan') {
                return redirect()->intended(route('pimpinan.dashboard'));
            }
            
            // Default untuk mustahik
            return redirect()->intended(route('mustahik.dashboard'));
        }

        // Jika gagal, kembali dengan pesan error yang sesuai di view
        return back()->with('error', 'Email atau Password salah!')->withInput($request->only('email'));
    }

    /**
     * Proses Registrasi (Hanya untuk Mustahik secara Default)
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mustahik', // Pendaftaran umum selalu mustahik
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}