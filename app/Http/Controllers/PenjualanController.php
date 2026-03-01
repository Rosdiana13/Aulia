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

            $totalTransaksi = 0;

            foreach ($items as $item) {

                DB::statement('CALL sp_penjualan_fifo(?, ?, ?, ?)', [
                    $idPenjualan,
                    $item['id'],
                    $item['qty'],
                    $item['harga']
                ]);

                $totalTransaksi += $item['qty'] * $item['harga'];
            }

            Penjualan::where('id', $idPenjualan)
                ->update(['total_transaksi' => $totalTransaksi]);

            DB::commit();

            return back()->with('success', 'Transaksi berhasil');

        } catch (\Exception $e) {

            DB::rollBack();

            $message = $e->errorInfo[2] ?? 'Terjadi kesalahan';

            return back()->with('error', $message);
        }
    }

}
