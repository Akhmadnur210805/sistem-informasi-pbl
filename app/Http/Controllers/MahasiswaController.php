<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function index(): View
    {
        // Karena view tidak menampilkan data dinamis dari controller,
        // kita cukup menampilkan view-nya saja.
        return view('mahasiswa.dashboard');
    }
}