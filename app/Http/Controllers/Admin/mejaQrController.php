<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\mejaQr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class mejaQrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meja = mejaQr::all();
        return view('admin.mejaQr', compact('meja'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.add-mejaQr');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|integer|unique:meja_qr,nomor_meja',
        ]);

        $token = Str::random(10);
        $url = url('/order/' . $token);

        $filename = 'qr_' . time() . '.png';
        $path = public_path('qrcodes/' . $filename);
        QrCode::format('png')->size(300)->generate($url, $path);

        MejaQr::create([
            'nomor_meja' => $request->nomor_meja,
            'qr_token' => $token,
            'qr_image' => 'qrcodes/' . $filename
        ]);

        return redirect()->route('admin.mejaQr.index')->with('success', 'Meja berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

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
}
