<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Saat pertama buka web, langsung lempar ke halaman Login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Route Autentikasi
Route::controller(AuthController::class)->group(function () {
    // Login
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login');
    
    // Logout (Wajib POST untuk keamanan session)
    Route::post('/logout', 'logout')->name('logout');
});

// 3. Kelompok Route yang HARUS Login dulu (Middleware Auth)
Route::middleware(['auth'])->group(function () {

    // Dashboard Utama
    Route::get('/dashboard', function () {
        return view('penjualan'); // Menggunakan template sebagai dashboard awal
    })->name('dashboard');

    // Fitur Inventori Toko Aulia
    Route::get('/barang', function () {
        return view('barang');
    })->name('barang.index');

    Route::get('/penjualan', function () {
        return view('penjualan');
    })->name('penjualan.index');

    Route::get('/restok', function () {
        return view('restok');
    })->name('restok.index');

    Route::get('/laporan', function () {
        return view('laporan');
    })->name('laporan.index');
    
    // Fitur Penyesuaian Stok (Tambahan Penting!)
    Route::get('/penyesuaian', function () {
        return view('penyesuaian');
    })->name('penyesuaian.index');

});