<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectTo(
            guests: '/', // Jika belum login, dilempar ke login
            users: function (Request $request) {
                // Logika pengalihan otomatis jika user sudah login
                $user = $request->user();
                if ($user->role === 'petugas') return route('petugas.dashboard');
                if ($user->role === 'pimpinan') return route('pimpinan.dashboard');
                return route('mustahik.dashboard');
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();