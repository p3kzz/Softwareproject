<?php

namespace App\Http\Controllers;

use App\Models\pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanan = pesanan::orderBy('created_at', 'desc')->get();

        return view('kasir.index', compact('pesanan'));
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

        return redirect()
            ->route('kasir.login')
            ->withErrors([
                'email' => 'Email atau password salah.',
            ]);
    }

    public function edit($id)
    {
        $pesanan = pesanan::findOrFail($id);
        return view('kasir.edit', compact('pesanan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai',
        ]);

        $pesanan = pesanan::findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->route('kasir.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pesanan = pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->route('kasir.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
