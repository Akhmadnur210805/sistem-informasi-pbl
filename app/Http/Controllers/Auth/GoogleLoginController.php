<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // 1. Cari user berdasarkan Email di database
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Jika user SUDAH ADA, pastikan google_id sinkron
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
                
                // Login user yang sudah ada
                Auth::login($user);
                
            } else {
                // Jika user BELUM ADA, buat akun pendaftar baru
                $user = User::create([ // <-- Menggunakan variabel $user agar konsisten
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'mustahik' // <-- Default user baru otomatis menjadi Mustahik
                ]);

                // Login user yang baru saja dibuat
                Auth::login($user);
            }

            // 2. CEK ROLE USER SETELAH BERHASIL LOGIN UNTUK REDIRECT
            // Logika ini ditaruh di luar if/else agar berlaku untuk user lama maupun user baru
            $loggedInUser = Auth::user();

            if ($loggedInUser->role === 'petugas') {
                return redirect()->route('petugas.dashboard');
            } elseif ($loggedInUser->role === 'pimpinan') {
                return redirect()->route('pimpinan.dashboard');
            } else {
                // Default-nya akan dilempar ke dashboard mustahik
                return redirect()->route('mustahik.dashboard');
            }

        } catch (\Exception $e) {
            // Jika terjadi error saat menarik data dari Google, kembalikan ke halaman login
            return redirect('/')->with('error', 'Login Google gagal, silakan coba lagi.');
        }
    }
}