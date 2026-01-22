<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Saat pertama buka web, langsung lempar ke halaman Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route Autentikasi
Route::controller(AuthController::class)->group(function () {
    // Login
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login');
    
    // Logout (Wajib POST untuk keamanan session)
    Route::post('/logout', 'logout')->name('logout');
});

// Kelompok Route yang HARUS Login dulu (Middleware Auth)
Route::middleware(['auth'])->group(function () {

    // Dashboard Utama
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Fitur Inventori Toko Aulia
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::post('/barang/store', [BarangController::class, 'store']);
    Route::post('/barang/update', [BarangController::class, 'update']);
    Route::get('/barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.delete');

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

    // Menampilkan halaman kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    
    // Proses simpan kategori baru
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    
    
    // Proses hapus kategori
    Route::delete('/kategori/destroy/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Route untuk pendaftaran pengguna baru yang tadi kita buat
    // Menampilkan form (Halaman Pengguna)
    Route::get('/pengguna', [AuthController::class, 'showRegisterForm']);

    // Proses Simpan
    Route::post('/register', [AuthController::class, 'register']);

    // Route untuk menghapus pengguna
    Route::get('/pengguna/delete/{id}', [AuthController::class, 'destroy']);

});