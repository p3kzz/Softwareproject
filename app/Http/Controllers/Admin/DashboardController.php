<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuModel;
use App\Models\Pelanggan;
use App\Models\pesanan;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalPesanan = pesanan::count();
        $totalHarga = pesanan::sum('total_harga');
        $totalMenu = MenuModel::count();
        $totalUser = User::count();
        $totalPelanggan = Pelanggan::count();
        $totalRating = Rating::count();

        return view('admin.dashboard', compact(
            'totalPesanan',
            'totalHarga',
            'totalMenu',
            'totalUser',
            'totalPelanggan',
            'totalRating',
        ));
    }
}
