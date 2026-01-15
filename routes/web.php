<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/template', function () {
    return view('template');
});

Route::get('/Login', function(){
    return view('Login');
});

Route::get('/penjualan', function () {
    return view('penjualan');
});

Route::get('/barang', function () {
    return view('barang');
});

Route::get('/restok', function () {
    return view('restok');
});

Route::get('/laporan', function () {
    return view('laporan');
});
