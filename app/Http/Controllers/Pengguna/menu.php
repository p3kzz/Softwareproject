<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use App\Models\MenuModel;
use Illuminate\Http\Request;

class menu extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $menus = MenuModel::with('kategori')->get();
    $categories = KategoriModel::all();
    $keranjang = session()->get('keranjang', []);
    $total = collect($keranjang)->sum(fn($item) => $item['harga'] * $item['jumlah']);

    return view('pengguna.menu', compact('menus', 'categories', 'keranjang', 'total'));
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
         $menuId = $request->input('id');
        $jumlah = $request->input('jumlah', 1);

        $menu = MenuModel::findOrFail($menuId);

        $item = [
            'id' => $menu->id,
            'nama_menu' => $menu->nama_menu,
            'harga' => $menu->harga,
            'jumlah' => $jumlah,
            'subtotal' => $menu->harga * $jumlah,
        ];

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$menuId])) {
            $keranjang[$menuId]['jumlah'] += $jumlah;
            $keranjang[$menuId]['subtotal'] = $keranjang[$menuId]['harga'] * $keranjang[$menuId]['jumlah'];
        } else {
            $keranjang[$menuId] = $item;
        }

        session(['keranjang' => $keranjang]);

        return redirect()->back()->with('success', 'Menu ditambahkan ke keranjang!');
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
        $keranjang = session()->get('keranjang', []);
        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] = $request->jumlah;
            $keranjang[$id]['subtotal'] = $keranjang[$id]['harga'] * $keranjang[$id]['jumlah'];
            session()->put('keranjang', $keranjang);
        }

        return redirect()->back()->with('success', 'Jumlah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $keranjang = session()->get('keranjang', []);
        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);
        }

        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }

     public function increment($id)
    {
        $keranjang = session()->get('keranjang', []);
        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] += 1;
            $keranjang[$id]['subtotal'] = $keranjang[$id]['harga'] * $keranjang[$id]['jumlah'];
            session()->put('keranjang', $keranjang);
        }

        return redirect()->back();
    }

    public function decrement($id)
    {
        $keranjang = session()->get('keranjang', []);
        if (isset($keranjang[$id])) {
            if ($keranjang[$id]['jumlah'] > 1) {
                $keranjang[$id]['jumlah'] -= 1;
                $keranjang[$id]['subtotal'] = $keranjang[$id]['harga'] * $keranjang[$id]['jumlah'];
                session()->put('keranjang', $keranjang);
            }
        }

        return redirect()->back();
    }
}
