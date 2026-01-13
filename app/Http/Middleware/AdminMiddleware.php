<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Impor Auth

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah user sudah login DAN memiliki role 'admin'
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            // Jika ya, lanjutkan request
            return $next($request);
        }

        // Jika tidak, redirect ke dashboard biasa atau halaman lain
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        // Atau bisa juga: abort(403, 'Unauthorized action.');
    }
}