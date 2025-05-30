<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\mejaQrController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\Pengguna\KeranjangController;
use App\Http\Controllers\Pengguna\menu;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Kasir;
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
        Route::resource('kasir', KasirController::class)->names('admin.kasir');
        Route::resource('menu', MenuController::class)->names('admin.menu');
        Route::resource('kategori', KategoriController::class)->names('admin.kategori');
        Route::resource('mejaQr', mejaQrController::class)->names('admin.mejaQr');
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
Route::get('/order/{token}', [PenggunaController::class, 'scanQR'])->name('scan.qr');
Route::resource('menu', menu::class)->names('pengguna.menu');
Route::get('/data', [PenggunaController::class, 'data']);
Route::patch('menu/{id}/tambah', [menu::class, 'increment'])->name('menu.increment');
Route::patch('menu/{id}/kurang', [menu::class, 'decrement'])->name('menu.decrement');

require __DIR__ . '/auth.php';
