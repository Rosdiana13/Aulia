<?php
namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenjualanController extends Controller
{
    public function index()
    {
        $barang = \App\Models\DataBarang::where('status', 1)
                    ->where('jumlah', '>', 0)
                    ->get();

        return view('penjualan', compact('barang'));
    }

   public function store(Request $request)
    {
        $items = json_decode($request->items, true);

        if (!$items || count($items) < 1) {
            return back()->with('error', 'Keranjang kosong');
        }

        try {

            DB::beginTransaction();

            $idPenjualan = (string) Str::uuid();

            Penjualan::create([
                'id' => $idPenjualan,
                'id_pengguna' => auth()->user()->id,
                'total_transaksi' => 0
            ]);

            foreach ($items as $item) {

                DetailPenjualan::create([
                    'id' => (string) Str::uuid(),
                    'id_penjualan' => $idPenjualan,
                    'id_data_barang' => $item['id'],
                    'jumlah' => $item['qty'],
                    'harga_saat_ini' => $item['harga'],
                    'sub_total_penjualan' => $item['qty'] * $item['harga']
                ]);
            }

            DB::commit();

            return back()->with('success', 'Transaksi berhasil disimpan');

        } catch (\Exception $e) {

            DB::rollBack();

            $message = $e->errorInfo[2] ?? 'Terjadi kesalahan';

            return back()->with('error', $message);
        }
    }

}
