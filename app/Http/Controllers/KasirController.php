<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kasir.index');
    }
    public function showLoginForm()
    {
        return view('auth.kasir-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        if (!$user || $user->role !== 'kasir') {
            return redirect('/');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/kasir');
        }

        return redirect()->route('kasir.login')->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
}
