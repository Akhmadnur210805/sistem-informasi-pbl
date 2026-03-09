<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

// Tambahan library wajib untuk Google SSO
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

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
            
            /** @var \App\Models\User $user */
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
        // SIMPAN HASIL VALIDASI KE DALAM VARIABEL $validated
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // GUNAKAN $validated ARRAY AGAR INTELEPHENSE TIDAK ERROR
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
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

    // ==========================================
    // FITUR LOGIN GOOGLE (SSO)
    // ==========================================

    /**
     * Mengarahkan pengguna ke halaman persetujuan Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Menerima respon balik (callback) dari Google setelah pengguna menyetujui
     */
    public function handleGoogleCallback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah email user sudah terdaftar di database kita
            $user = User::where('email', $googleUser->getEmail())->first();

            // Jika belum terdaftar, buat akun baru secara otomatis
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(16)), // Password acak yang aman
                    'role' => 'mustahik', // Set default role
                ]);
            }

            // Autentikasi/Login-kan user tersebut
            Auth::login($user);

            // Arahkan ke dashboard berdasarkan role (sama seperti fungsi login manual)
            if ($user->role === 'petugas') {
                return redirect()->route('petugas.dashboard');
            } elseif ($user->role === 'pimpinan') {
                return redirect()->route('pimpinan.dashboard');
            } else {
                return redirect()->route('mustahik.dashboard')->with('success', 'Berhasil masuk dengan Google!');
            }

        } catch (\Exception $e) {
            // Jika terjadi kesalahan (misal pengguna membatalkan proses)
            return redirect()->route('login')->with('error', 'Gagal masuk menggunakan Google. Silakan coba lagi.');
        }
    }
}