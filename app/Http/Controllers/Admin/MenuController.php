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
            'nama_menu' => 'required|string|max:255|unique:menu,nama_menu',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'stok' => 'required|numeric',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namafile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $namafile);
            $validated['gambar'] = 'images/' . $namafile;
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
        $kategori = KategoriModel::all();
        $menu = MenuModel::findOrFail($id);
        return view('admin.menu-edit', compact('menu', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = MenuModel::findOrFail($id);
        $request->validate([
            'nama_menu' => 'required|string|max:255|unique:menu,nama_menu,' . $id,
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'stok' => 'required|numeric',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namafile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $namafile);
            $validated['gambar'] = 'images/' . $namafile;
        } else {
            $validated['gambar'] = $menu->gambar;
        }

        $menu->nama_menu = $request->nama_menu;
        $menu->deskripsi = $request->deskripsi;
        $menu->harga = $request->harga;
        $menu->stok = $request->stok;
        $menu->kategori_id = $request->kategori_id;
        $menu->save();
        return redirect()->route('admin.menu.index')->with('success', 'menu berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = MenuModel::findOrFail($id);
        $menu->delete();
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil di perbarui');
    }
}
