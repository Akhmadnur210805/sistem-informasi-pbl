<?php

namespace App\Http\Controllers\Auth; // <--- NAMESPACE HARUS INI

use App\Http\Controllers\Controller; // <--- WAJIB IMPORT INI
use Illuminate\Http\Request;
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

            // 1. Cari user berdasarkan Email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Jika user ada, update google_id biar sinkron
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }

                Auth::login($user);
                
                // Redirect langsung ke dashboard mahasiswa
                return redirect('/dashboard_mahasiswa'); 

            } else {
                // Jika user tidak ada, buat baru
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'mahasiswa' // Pastikan role default diset (opsional)
                ]);

                Auth::login($newUser);
                return redirect('/dashboard_mahasiswa');
            }

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login Google Gagal: ' . $e->getMessage());
        }
    }
}