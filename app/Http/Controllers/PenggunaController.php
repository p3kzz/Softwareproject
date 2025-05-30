<?php

namespace App\Http\Controllers;

use App\Models\mejaQr;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!session()->has('meja_id')) {
            return redirect('/')->with('error', 'Silakan scan QR code terlebih dahulu.');
        }
        return view('pengguna.index');
    }
    public function scanQR($token)
    {
        $meja = \App\Models\MejaQr::where('qr_token', $token)->first();

        if (!$meja) {
            dd('Token tidak ditemukan: ' . $token);
        }

        session([
            'meja_id' => $meja->id,
            'nomor_meja' => $meja->nomor_meja,
        ]);

        return redirect()->route('pengguna.index');
    }

    public function tampil()
    {
        return view('pengguna.index');
    }

    public function menu()
    {
        return view('pengguna.menu');
    }

    public function data()
    {
        return view('pengguna.data');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function keluar()
    {
        session()->flush(); // Menghapus semua data session

        return redirect('/')->with('success', 'Berhasil keluar.');
    }
}
