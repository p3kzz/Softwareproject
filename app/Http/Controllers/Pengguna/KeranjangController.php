<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\MenuModel;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = session()->get('keranjang', []);
        $total = collect($keranjang)->sum(fn($item) => $item['harga'] * $item['jumlah']);

        return view('pengguna.keranjang', compact('keranjang', 'total'));
    }

    public function create()
    {
        //
    }

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

        return redirect()->route('keranjang.index')->with('success', 'Menu ditambahkan ke keranjang!');
    }

    public function show(string $id) {}

    public function edit(string $id) {}

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
