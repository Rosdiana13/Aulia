<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

// Protected
Route::middleware(['auth'])->group(function () {

    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

    // BARANG
    Route::get('/barang', [DataBarangController::class, 'index'])->name('barang.index');
    Route::post('/barang', [DataBarangController::class, 'store'])->name('barang.store');
    Route::put('/barang/{id}', [DataBarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [DataBarangController::class, 'destroy'])->name('barang.destroy');

    // KATEGORI
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // PENJUALAN
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');


    // LAINNYA
    Route::view('/pembelian', 'pembelian')->name('pembelian.index');
    Route::view('/deadstock', 'deadstock')->name('deadstock.index');
    Route::view('/penyesuaian', 'penyesuaian')->name('penyesuaian.index');

});