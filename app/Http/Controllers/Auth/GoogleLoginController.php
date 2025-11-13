<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite; // Penting
use App\Models\User;                      // Penting
use Illuminate\Support\Facades\Auth;      // Penting
use Illuminate\Support\Facades\Hash;      // Penting
use Illuminate\Support\Str;                 // Penting

class GoogleLoginController extends Controller
{
    /**
     * Mengarahkan pengguna ke halaman autentikasi Google.
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
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah ada di database berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // --- PENGGUNA DITEMUKAN ---
                // Jika pengguna sudah ada, update google_id jika masih kosong
                $user->update([
                    'google_id' => $user->google_id ?? $googleUser->getId(),
                ]);

                Auth::login($user);
                return redirect()->intended('/dashboard_mahasiswa'); // Arahkan ke dashboard

            } else {
                // --- PENGGUNA TIDAK DITEMUKAN ---
                // Jika pengguna tidak ada, buat pengguna baru
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(24)) // Buat password acak yang aman
                ]);

                Auth::login($newUser);
                return redirect()->intended('/dashboard_mahasiswa'); // Arahkan ke dashboard
            }

        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan ke halaman login
            return redirect('/login')->with('error', 'Login dengan Google gagal: ' . $e->getMessage());
        }
    }
}