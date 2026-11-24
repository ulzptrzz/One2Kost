<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->isAdmin()) {
            return redirect()->route('tenant.dashboard')->with('error', 'Akses ditolak. Halaman ini hanya untuk Pengelola Kost.');
        }

        return $next($request);
    }
}
