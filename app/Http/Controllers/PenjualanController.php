<?php
namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Models\DataBarang;
use Illuminate\Support\Str;

class PenjualanController extends Controller
{
    public function index()
    {
        $barang = DataBarang::where('status', 1)
                    ->where('jumlah', '>', 0)
                    ->get();

        return view('penjualan', compact('barang'));
    }

    public function history(Request $request)
    {
        $query = DB::table('v_history_penjualan');

        if ($request->tanggal_awal && $request->tanggal_akhir) {

            $query->whereBetween('tanggal_penjualan', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

         if ($request->search) {

            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $history_penjualan = $query
            ->orderBy('tanggal_penjualan', 'desc')
            ->paginate(10);

        return view('history_penjualan', compact('history_penjualan'));
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

            // TAMBAHAN
            $diskon = $request->diskon ?? 0;

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

            // TAMBAHAN
            $totalAkhir = $totalTransaksi - $diskon;

            if ($totalAkhir < 0) {
                $totalAkhir = 0;
            }

            Penjualan::where('id', $idPenjualan)
                ->update([
                    'total_sebelum_diskon' => $totalTransaksi,
                    'diskon' => $diskon,
                    'total_transaksi' => $totalAkhir
                ]);

            DB::commit();

            return back()->with('success', 'Transaksi berhasil');

        } catch (\Exception $e) {

            DB::rollBack();

            $message = $e->errorInfo[2] ?? 'Terjadi kesalahan';

            return back()->with('error', $message);
        }
    }

}
