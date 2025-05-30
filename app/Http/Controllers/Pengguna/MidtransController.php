<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Ambil notifikasi dari Midtrans
        $notification = new Notification();

        $transaction = $notification->transaction_status;
        $type        = $notification->payment_type;
        $pesanan   = $notification->pesanan;
        $fraud       = $notification->fraud_status;

        // Log agar bisa dicek kalau error
        Log::info('Midtrans Notification', [
            'pesanan' => $pesanan,
            'transaction_status' => $transaction,
            'payment_type' => $type,
            'fraud_status' => $fraud,
        ]);

        // Cari pesanan berdasarkan pesanan
        $pesanan = pesanan::where('snap_token', $pesanan)->first();

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        // Update status pesanan sesuai status pembayaran Midtrans
        if ($transaction == 'capture' || $transaction == 'settlement') {
            $pesanan->status = 'dibayar';
        } elseif ($transaction == 'pending') {
            $pesanan->status = 'pending';
        } elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
            $pesanan->status = 'gagal';
        }

        $pesanan->save();

        return response()->json(['message' => 'Notifikasi diproses'], 200);
    }
}
