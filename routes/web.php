<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pengguna.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard.admin');
// });
Route::middleware(['auth', Admin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'pengguna'])->group(function () {
    Route::get('/dashboard', [PenggunaController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'kasir'])->group(function () {
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
});

require __DIR__ . '/auth.php';

Route::get('/admin.index', [AdminController::class, 'admin']);
Route::get('/menu', [PenggunaController::class, 'menu']);
Route::get('/data', [PenggunaController::class, 'data']);
