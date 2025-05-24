<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use App\Models\MenuModel;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = MenuModel::with('kategori')->get();
        return view('admin.menu', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = KategoriModel::all();
        return view('admin.add-menu', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'stok' => 'required|numeric',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namafile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('public/images'), $namafile);
            $validated['gambar'] = 'public/images/' . $namafile;
        }

        MenuModel::create($validated);
        return redirect()->route('admin.menu.index')->with('success', 'menu berhasil ditambahkan');
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
}
