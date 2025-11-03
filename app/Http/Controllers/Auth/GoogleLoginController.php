<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

class GoogleLoginController extends Controller
{
    /**
     * Mengarahkan pengguna ke halaman otentikasi Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Mendapatkan informasi pengguna dari Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan google_id
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                // Jika user tidak ada, cek berdasarkan email
                $user = User::where('email', $googleUser->getEmail())->first();

                if ($user) {
                    // Jika email ada, update google_id-nya
                    $user->update(['google_id' => $googleUser->getId()]);
                } else {
                    // Jika email dan google_id tidak ada, buat user baru
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'password' => null, // Password null
                        'role' => 'mahasiswa' // --- SET DEFAULT ROLE DI SINI ---
                    ]);
                }
            }

            // --- INI BAGIAN UTAMA YANG DIPERBAIKI ---

            // 1. Loginkan pengguna
            Auth::login($user);

            // 2. Cek role dan arahkan ke dashboard yang benar
            // Ini akan MENGHINDARI REDIRECT LOOP
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'dosen':
                    return redirect()->route('dosen.dashboard');
                case 'pengelola':
                    return redirect()->route('pengelola.dashboard');
                case 'mahasiswa':
                default:
                    // Jika rolenya mahasiswa atau role lain yang tidak terdaftar
                    return redirect()->route('mahasiswa.dashboard');
            }
            // ---------------------------------------------

        } catch (Exception $e) {
            // Jika ada error (termasuk error validasi $fillable dari model User)
            // kirim kembali ke login dengan pesan error untuk debugging
            return redirect('/login')->with('error', 'Login Google gagal: ' . $e->getMessage());
        }
    }
}
