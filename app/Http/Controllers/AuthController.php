<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLoginForm(): View
    {
        return view('login');
    }

    /**
     * Display the registration form.
     */
    public function showRegisterForm(): View
    {
        return view('register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_admin' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5'],
        ]);

        // Buat user baru
        $user = User::create([
            'kode_admin' => $request->kode_admin,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa', // Atur role sebagai mahasiswa
        ]);

        // Login user yang baru dibuat
        Auth::login($user);

        // Arahkan ke dashboard mahasiswa
        return redirect()->intended('/dashboard_mahasiswa');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'kode_admin' => ['required'],
            'password' => ['required'],
        ]);

        // Coba login dengan kredensial yang diberikan
        if (Auth::attempt($credentials)) {
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

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}