<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataBarangController extends Controller
{
    public function index()
    {
        $barang = DataBarang::with('kategori')
            ->where('status', 1)
            ->get();

        $kategori = Kategori::where('status', 1)->get();

        return view('barang', compact('barang', 'kategori'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|max:200',
            'id_kategori' => 'required',
            'harga_beli'  => 'required|numeric',
            'harga_jual'  => 'required|numeric',
            'jumlah'      => 'required|numeric|min:1',
            'min_stok'    => 'required|numeric|min:0'
        ]);

        try {

            DB::statement('CALL sp_store_barang(?, ?, ?, ?, ?, ?, ?)', [
                auth()->user()->id,
                $request->id_kategori,
                $request->nama_barang,
                $request->harga_beli,
                $request->harga_jual,
                $request->jumlah,
                $request->min_stok
            ]);

            return redirect()->back()->with('success', 'Barang berhasil diproses');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|max:200',
            'id_kategori' => 'required',
            'harga_jual'  => 'required|numeric',
            'min_stok'    => 'required|numeric|min:0'
        ]);

        try {

            DB::statement('CALL sp_update_barang(?, ?, ?, ?, ?)', [
                $id,
                $request->nama_barang,
                $request->id_kategori,
                $request->harga_jual,
                $request->min_stok
            ]);

            return redirect()->back()->with('success', 'Data barang berhasil diperbarui');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

  public function destroy($id)
    {
        try {

            DB::statement('CALL sp_soft_delete_barang(?)', [$id]);

            return redirect()->back()->with('success', 'Barang berhasil dihapus');

        } catch (\Exception $e) {

            $message = $e->errorInfo[2] ?? 'Terjadi kesalahan';

            return redirect()->back()->with('error', $message);
        }
    }
}
