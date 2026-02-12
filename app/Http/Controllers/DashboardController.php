<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataBarang;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total jenis barang aktif
        $total_barang = DataBarang::where('status', 1)->count();

        // Total stok unit
        $total_stok = DataBarang::where('status', 1)->sum('jumlah');

        // Penjualan hari ini
        $penjualan_hari_ini = DetailPenjualan::join('penjualan', 'detail_penjualan.id_penjualan', '=', 'penjualan.id')
            ->join('data_barang', 'detail_penjualan.id_data_barang', '=', 'data_barang.id')
            ->whereDate('penjualan.tanggal_penjualan', today())
            ->select(
                'data_barang.nama_barang',
                'penjualan.tanggal_penjualan as tanggal',
                'detail_penjualan.jumlah',
                'detail_penjualan.harga_saat_ini as harga_jual',
                'detail_penjualan.sub_total_penjualan as subtotal'
            )
            ->get();

        // Total pendapatan hari ini
        $total_pendapatan_hari_ini = $penjualan_hari_ini->sum('subtotal');

        return view('dashboard', compact(
            'total_barang',
            'total_stok',
            'penjualan_hari_ini',
            'total_pendapatan_hari_ini'
        ));
    }
}
