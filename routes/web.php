<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pengguna.index');
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

require __DIR__ . '/auth.php';

Route::get('/menu', [PenggunaController::class, 'menu']);
Route::get('/data', [PenggunaController::class, 'data']);
