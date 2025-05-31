<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\addkasir;
use App\Http\Controllers\Admin\AddKasirController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\mejaQrController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\Pengguna\CheckoutController;
use App\Http\Controllers\Pengguna\KeranjangController;
use App\Http\Controllers\Pengguna\menu;
use App\Http\Controllers\Pengguna\MidtransController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Kasir;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');
        Route::resource('menu', MenuController::class)->names('admin.menu');
        Route::resource('kategori', KategoriController::class)->names('admin.kategori');
        Route::resource('mejaQr', mejaQrController::class)->names('admin.mejaQr');
        Route::resource('kasir', AddKasirController::class)->names('admin.kasir');
        Route::get('/kasir/{id}/edit', [AddKasirController::class, 'edit'])->name('kasir.edit');
        Route::put('/kasir/{id}', [AddKasirController::class, 'update'])->name('kasir.update');
        Route::delete('/kasir/{id}', [AddKasirController::class, 'destroy'])->name('kasir.destroy');
    });
});

// kasir
Route::prefix('kasir')->group(function () {
    Route::get('/login', [KasirController::class, 'showLoginForm'])->name('kasir.login');
    Route::post('/login', [KasirController::class, 'login'])->name('kasir.login');
    Route::post('/logout', [KasirController::class, 'logout'])->name('kasir.logout');

    Route::middleware(['auth', 'kasir'])->group(function () {
        Route::get('/', [KasirController::class, 'index'])->name('kasir');
    });
});

// profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'pengguna'])->group(function () {
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
});

Route::middleware(['auth', 'kasir'])->group(function () {
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
});

// pengguna
Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
Route::get('/keluar', [PenggunaController::class, 'keluar'])->name('pengguna.keluar');

Route::get('/order/{token}', [PenggunaController::class, 'scanQR'])->name('scan.qr');
Route::resource('menu', menu::class)->names('pengguna.menu');
Route::get('/data', [PenggunaController::class, 'data']);
Route::patch('menu/{id}/tambah', [menu::class, 'increment'])->name('menu.increment');
Route::patch('menu/{id}/kurang', [menu::class, 'decrement'])->name('menu.decrement');

// checkout
Route::resource('checkout', CheckoutController::class);
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// Form isian untuk tamu (guest)
Route::get('/checkout/guest/{pesanan}', [CheckoutController::class, 'create'])->name('checkout.guest');

// Proses store (buat pesanan + dapatkan SnapToken)
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/bayar/{pesanan}', [CheckoutController::class, 'bayar'])->name('checkout.bayar');
Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler'])->name('midtrans.notification');
Route::post('/midtrans/notification', [CheckoutController::class, 'handleNotification']);

require __DIR__ . '/auth.php';
