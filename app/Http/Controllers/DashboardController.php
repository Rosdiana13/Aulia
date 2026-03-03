<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataBarang;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total jenis barang aktif
        $total_barang = DataBarang::where('status', 1)->count();

        // Total stok unit
        $total_stok = DataBarang::where('status', 1)->sum('jumlah');

        // Penjualan hari ini (Pagination)
        $penjualan_hari_ini = DB::table('detail_penjualan as dp')
            ->join('penjualan as p', 'dp.id_penjualan', '=', 'p.id')
            ->join('data_barang as db', 'dp.id_data_barang', '=', 'db.id')
            ->whereDate('p.tanggal_penjualan', now()->toDateString())
            ->select(
                'db.nama_barang',
                'p.tanggal_penjualan as tanggal',
                'dp.jumlah',
                'dp.harga_saat_ini as harga_jual',
                'dp.sub_total_penjualan as subtotal'
            )
            ->orderBy('p.tanggal_penjualan', 'desc')
            ->paginate(5);

        // Total pendapatan hari ini (query terpisah supaya tidak ikut pagination)
        $total_pendapatan_hari_ini = DB::table('detail_penjualan as dp')
            ->join('penjualan as p', 'dp.id_penjualan', '=', 'p.id')
            ->whereDate('p.tanggal_penjualan', now()->toDateString())
            ->sum('dp.sub_total_penjualan');

        return view('dashboard', compact(
            'total_barang',
            'total_stok',
            'penjualan_hari_ini',
            'total_pendapatan_hari_ini'
        ));
    }
}