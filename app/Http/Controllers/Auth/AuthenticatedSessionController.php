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

        $user = Auth::user();

        if ($user->role === 'admin') {
            Auth::logout();
            return redirect('/login')->withErrors([
                'email' => 'Admin tidak boleh login dari halaman ini.',
            ]);
        }

        // ✅ Cek apakah sebelumnya user mau checkout
        if (session('checkout_after_login')) {
            session()->forget('checkout_after_login'); // hilangkan flag

            // 👉 Buat pesanan langsung di sini (atau bisa redirect ke controller yang buat pesanan)
            return redirect()->route('checkout.store.login');
        }

        // Role-based redirect (jika bukan checkout)
        if ($user->role === 'pengguna') {
            return redirect()->intended('/pengguna');
        }

        return redirect()->intended('/dashboard');
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
