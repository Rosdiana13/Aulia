<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataBarang;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Jumlah Barang Dead Stock
        $days = 30;

        $total_deadstock = DB::table('v_dead_stock')
            ->where('lama_mengendap', '>=', $days)
            ->count();


        // Menapilkan Barang Untuk di Restok
        $barang_restok = DataBarang::with('kategori')
                        ->whereColumn('jumlah', '<=', 'min_stok')
                        ->where('status', 1)
                        ->orderBy('jumlah', 'asc') 
                        ->limit(5) 
                        ->get();
                        
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

        // Ambil filter
        $filter = request('filter', 'harian');
        $range = request('range', 30);

        // HARlAN (default 30 hari)
        if ($filter == 'harian') {

            $grafik_penjualan = DB::table('penjualan')
                ->selectRaw('DATE(tanggal_penjualan) as tanggal, SUM(total_transaksi) as total')
                ->where('tanggal_penjualan', '>=', now()->subDays($range))
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            $tanggal = $grafik_penjualan->pluck('tanggal')->map(function($tgl){
                return \Carbon\Carbon::parse($tgl)->format('d M');
            });

        }

        // Grafik BULANAN
        else {

            $grafik_penjualan = DB::table('penjualan')
                ->selectRaw('DATE_FORMAT(tanggal_penjualan, "%Y-%m") as bulan, SUM(total_transaksi) as total')
                ->where('tanggal_penjualan', '>=', now()->subMonths(12))
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();

            $tanggal = $grafik_penjualan->pluck('bulan')->map(function($bln){
                return \Carbon\Carbon::parse($bln . '-01')->format('M Y');
            });
        }

        $total_penjualan = $grafik_penjualan->pluck('total');

        return view('dashboard', compact(
            'total_barang',
            'total_stok',
            'penjualan_hari_ini',
            'total_pendapatan_hari_ini',
            'tanggal',
            'total_penjualan',
            'barang_restok',
            'total_deadstock'
        ));
    }
}