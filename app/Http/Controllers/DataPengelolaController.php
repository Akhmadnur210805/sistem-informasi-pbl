<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DataPengelolaController extends Controller
{
    /**
     * Menampilkan halaman daftar pengelola.
     */
    public function index(): View
    {
        // Mengambil semua user yang memiliki role 'pengelola'
        $pengelolas = User::where('role', 'pengelola')->get();
        
        return view('admin.pengelola.index', ['pengelolas' => $pengelolas]);
    }
}