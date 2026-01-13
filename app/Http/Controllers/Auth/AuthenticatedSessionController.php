<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // === LOGIKA PENGALIHAN BERDASARKAN ROLE ===
        // Periksa apakah user yang baru login memiliki role 'admin'
        if ($request->user()->hasRole('admin')) {
            // Jika ya, arahkan ke rute 'admin.dashboard'
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
        // =======================================

        // Jika bukan admin (berarti user biasa), arahkan ke rute 'dashboard' biasa
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

