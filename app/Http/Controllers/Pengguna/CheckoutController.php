<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\detail_pesanan;
use App\Models\MenuModel;
use App\Models\Pelanggan;
use App\Models\pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('checkout.storeAfterLogin');
        }
        session(['checkout_after_login' => true]);
        return view('checkout.index');
    }

    public function create()
    {
        return view('checkout.guest-form');
    }

    public function store(Request $request)
    {
        try {
            [$user_id, $pelanggan_id] = $this->handleUser($request);

            $keranjang = session('keranjang', []);
            if (empty($keranjang)) {
                return response()->json(['error' => 'Keranjang kosong'], 400);
            }

            $total = $this->hitungTotal($keranjang);
            $orderId = 'ORDER-' . time();

            $pesanan = $this->buatPesanan($request, $user_id, $pelanggan_id, $total, $keranjang, $orderId);

            $this->konfigurasiMidtrans();
            $snapToken = $this->buatSnapToken($request, $total, $orderId);

            $pesanan->snap_token = $snapToken;
            $pesanan->save();

            session()->forget('keranjang');

            return response()->json([
                'snap_token' => $snapToken,
                'pesanan_id' => $pesanan->id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function bayar(pesanan $pesanan)
    {
        $view = Auth::check() ? 'checkout.bayar-login' : 'checkout.guest-form';

        return view($view, [
            'pesanan' => $pesanan,
            'snapToken' => $pesanan->snap_token,
        ]);
    }


    public function storeAfterLogin()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $meja_id = session('meja_id');

        if (!$meja_id) {
            return redirect()->route('checkout.index')->with('error', 'QR belum discan.');
        }

        $keranjang = session('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->route('keranjang')->with('error', 'Keranjang kosong.');
        }

        $total = $this->hitungTotal($keranjang);

        // Cek apakah user pernah dapat diskon
        $isDiskon = !$user->pernah_diskon;

        $hargaSetelahDiskon = $isDiskon ? $total * 0.9 : $total;

        $pesanan = Pesanan::create([
            'users_id' => $user->id,
            'pelanggan_id' => null,
            'meja_id' => $meja_id,
            'total_harga' => $hargaSetelahDiskon,
            'status' => 'pending',
            'order_id' => 'ORDER-' . time(),
        ]);

        foreach ($keranjang as $menu_id => $item) {
            $menu = MenuModel::find($menu_id);
            if (!$menu) {
                throw new \Exception("Menu dengan ID $menu_id tidak ditemukan.");
            }

            if ($menu->stok < $item['jumlah']) {
                throw new \Exception("Stok menu '{$menu->nama}' tidak mencukupi.");
            }
            $menu->stok -= $item['jumlah'];
            $menu->save();
            detail_pesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id' => $menu_id,
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
            ]);
        }

        // Simpan token pembayaran
        $this->konfigurasiMidtrans();
        $snapToken = $this->buatSnapToken(new Request(), $hargaSetelahDiskon);
        $pesanan->snap_token = $snapToken;
        $pesanan->save();

        // Tandai user sudah pernah diskon
        if ($isDiskon) {
            $user->pernah_diskon = true;
            $user->save();
        }

        session()->forget('keranjang');

        return redirect()->route('checkout.bayar', $pesanan->id);
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
        return array_reduce(
            $keranjang,
            function ($total, $item) {
                return $total + $item['harga'] * $item['jumlah'];
            },
            0,
        );
    }

    private function buatPesanan(Request $request, $user_id, $pelanggan_id, $total, $keranjang, $orderId)
    {
        $pesanan = pesanan::create([
            'users_id' => $user_id,
            'pelanggan_id' => $pelanggan_id,
            'meja_id' => $request->meja_id,
            'total_harga' => $total,
            'status' => 'pending',
            'order_id' => $orderId,
        ]);

        foreach ($keranjang as $menu_id => $item) {
            $menu = MenuModel::find($menu_id);
            if (!$menu) {
                throw new \Exception("Menu dengan ID $menu_id tidak ditemukan.");
            }

            if ($menu->stok < $item['jumlah']) {
                throw new \Exception("Stok menu '{$menu->nama}' tidak mencukupi.");
            }
            $menu->stok -= $item['jumlah'];
            $menu->save();

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
                'order_id' => 'ORDER-' . time(),
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => Auth::check() ? Auth::user()->name : $request->nama,
                'phone' => Auth::check() ? Auth::user()->no_hp : $request->no_hp,
            ],
        ]);
    }
    public function handleNotification(Request $request)
    {
        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        // Cari pesanan
        $pesanan = Pesanan::where('order_id', $order_id)->first();

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        // Update status
        if ($transaction == 'settlement') {
            $pesanan->status = 'paid';
        } elseif ($transaction == 'pending') {
            $pesanan->status = 'pending';
        } elseif ($transaction == 'expire') {
            $pesanan->status = 'expired';
        } elseif ($transaction == 'cancel' || $transaction == 'deny') {
            $pesanan->status = 'failed';
        }

        $pesanan->save();

        return response()->json(['message' => 'Notification processed']);
    }
    public function success($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if (Auth::check()) {
            $riwayat = Pesanan::where('users_id', Auth::id())->orderBy('created_at', 'desc')->get();
        } else {
            $pelangganId = session('pelanggan_id');
            $riwayat = Pesanan::where('pelanggan_id', $pelangganId)->orderBy('created_at', 'desc')->get();
        }

        return view('checkout.success', compact('pesanan', 'riwayat'));
    }

    public function riwayat()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Harap login terlebih dahulu.');
        }

        $pesanan = pesanan::where('users_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('checkout.riwayat', compact('pesanan'));
    }

    public function riwayatGuest()
    {
        $pelangganId = session('pelanggan_id');
        if (!$pelangganId) {
            return redirect()->route('checkout.create')->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $pesanan = Pesanan::with('detail_pesanan.menu')
            ->where('pelanggan_id', $pelangganId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('checkout.riwayat', compact('pesanan'));
    }
}
