<?php

namespace App\Http\Controllers;


class PimpinanController extends Controller
{
    public function dashboard()
    {
        return view('pimpinan.dashboard'); // Memanggil file resources/views/pimpinan/dashboard.blade.php
    }
}