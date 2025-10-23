<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('login');
    }

    public function showRegisterForm(): View
    {
        return view('register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'kode_admin' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'ends_with:@mhs.politala.ac.id'],
            'password' => ['required', 'string', 'min:5'],
        ], [
            'email.ends_with' => 'Registrasi hanya diizinkan untuk email @mhs.politala.ac.id.'
        ]);

        $user = User::create([
            'kode_admin' => $request->kode_admin,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        Auth::login($user);
        return redirect()->intended('/dashboard_mahasiswa');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Logika Validasi Domain yang Lebih Ringkas
        $email = $credentials['email'];
        $allowedDomains = ['@mhs.politala.ac.id', '@politala.ac.id'];
        $specialEmails = ['admin@example.com'];

        if (!Str::endsWith($email, $allowedDomains) && !in_array($email, $specialEmails)) {
            return back()->withErrors([
                'email' => 'Domain email Anda tidak diizinkan untuk login.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/dashboard_admin');
                case 'dosen':
                    return redirect()->intended('/dashboard_dosen');
                case 'mahasiswa':
                    return redirect()->intended('/dashboard_mahasiswa');
                case 'pengelola':
                    return redirect()->intended('/dashboard_pengelola');
                default:
                    Auth::logout();
                    return redirect('/login');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $email = $googleUser->getEmail();

            if (!Str::endsWith($email, '@mhs.politala.ac.id')) {
                return redirect('/login')->withErrors(['email' => 'Login via Google hanya untuk mahasiswa (@mhs.politala.ac.id).']);
            }

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'mahasiswa'
                ]
            );

            Auth::login($user, true);
            return redirect()->intended('/dashboard_mahasiswa');

        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['email' => 'Gagal melakukan otentikasi dengan Google.']);
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}