<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PembelianController extends Controller
{
    public function index()
    {
        $barang_restok = DataBarang::with('kategori')
            ->whereColumn('jumlah', '<=', 'min_stok')
            ->where('status', 1)
            ->get();

        return view('pembelian', compact('barang_restok'));
    }

    public function restok(Request $request)
    {
        $request->validate([
            'id_barang' => 'required',
            'qty_masuk' => 'required|numeric|min:1',
            'harga_beli_baru' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {

            $barang = DataBarang::findOrFail($request->id_barang);

            // 🔹 Tambah stok dulu
            $barang->update([
                'jumlah' => $barang->jumlah + $request->qty_masuk
            ]);

            // 🔹 Hitung subtotal
            $subtotal = $request->qty_masuk * $request->harga_beli_baru;

            // 🔹 Buat header pembelian
            $pembelian = Pembelian::create([
                'id' => Str::uuid(),
                'id_pengguna' => auth()->user()->id,
                'total_pembelian' => 0 // nanti trigger update
            ]);

            // 🔹 Insert detail pembelian
            DetailPembelian::create([
                'id' => Str::uuid(),
                'id_data_barang' => $barang->id,
                'id_pembelian' => $pembelian->id,
                'jumlah' => $request->qty_masuk,
                'harga_beli_baru' => $request->harga_beli_baru,
                'sub_total_pembelian' => $subtotal
            ]);

            DB::commit();

            return back()->with('success', 'Restok berhasil dilakukan');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan saat restok');
        }
    }
}
