<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\detail_pesanan;
use App\Models\Pelanggan;
use App\Models\pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function create()
    {
        return view('checkout.guest-form');
    }

    public function store(Request $request)
    {
        // Validasi dan simpan data pengguna
        [$user_id, $pelanggan_id] = $this->handleUser($request);

        // Ambil keranjang dari session
        $keranjang = session('keranjang', []);
        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang Kosong');
        }

        $total = $this->hitungTotal($keranjang);

        // Simpan pesanan dan detailnya
        $pesanan = $this->buatPesanan($request, $user_id, $pelanggan_id, $total, $keranjang);

        // Buat Snap Token Midtrans
        $this->konfigurasiMidtrans();
        $snapToken = $this->buatSnapToken($request, $total);
        $pesanan->snap_token = $snapToken;
        $pesanan->save();

        session()->forget('keranjang');

        return redirect()->route('checkout.bayar', $pesanan->id);
    }

    public function bayar(pesanan $pesanan)
    {
        return view('checkout.bayar', [
            'pesanan' => $pesanan,
            'snapToken' => $pesanan->snap_token,
        ]);
    }

    public function success()
    {
        return view('checkout.success');
    }

    // ============================
    // PRIVATE FUNCTION SECTION
    // ============================

    private function handleUser(Request $request)
    {
        if (Auth::check()) {
            return [Auth::id(), null];
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'meja_id' => 'required|exists:meja_qr,id',
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'meja_id' => $request->meja_id,
        ]);

        session(['pelanggan_id' => $pelanggan->id]);

        return [null, $pelanggan->id];
    }

    private function hitungTotal(array $keranjang): int
    {
        return array_reduce($keranjang, function ($total, $item) {
            return $total + ($item['harga'] * $item['jumlah']);
        }, 0);
    }

    private function buatPesanan(Request $request, $user_id, $pelanggan_id, $total, $keranjang)
    {
        $pesanan = pesanan::create([
            'users_id' => $user_id,
            'pelanggan_id' => $pelanggan_id,
            'meja_id' => $request->meja_id,
            'total_harga' => $total,
            'status' => 'pending',
        ]);

        foreach ($keranjang as $menu_id => $item) {
            detail_pesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id' => $menu_id,
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
            ]);
        }

        return $pesanan;
    }

    private function konfigurasiMidtrans()
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    private function buatSnapToken(Request $request, $total)
    {
        return \Midtrans\Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => rand(), // Ganti ini jadi id pesanan jika ingin konsisten
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => Auth::check() ? Auth::user()->name : $request->nama,
                'phone' => Auth::check() ? Auth::user()->no_hp : $request->no_hp,
            ]
        ]);
    }
}
