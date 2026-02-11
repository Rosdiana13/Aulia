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

    /** BARANG MASUK PERTAMA KALI Dicatat sebagai pembelian **/
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

        $pesan = 'Barang berhasil ditambahkan dan pembelian dicatat';

        DB::transaction(function () use ($request, &$pesan) {

            $nama = trim(strtolower($request->nama_barang));

            // CARI TANPA PEDULI HURUF BESAR KECIL & SPA SI
            $barang = DataBarang::whereRaw('LOWER(TRIM(nama_barang)) = ?', [$nama])
                ->where('id_kategori', $request->id_kategori)
                ->first();

            // PEMBELIAN
            $pembelian = Pembelian::create([
                'id_pengguna'     => auth()->user()->id,
                'total_pembelian' => 0
            ]);

            if ($barang) {

                // JIKA STATUS 0 → AKTIFKAN KEMBALI
                if ($barang->status == 0) {

                    $barang->update([
                        'status'     => 1,
                        'jumlah'     => $request->jumlah,
                        'harga_beli' => $request->harga_beli,
                        'harga_jual' => $request->harga_jual,
                        'min_stok'   => $request->min_stok
                    ]);

                    $pesan = 'Barang diaktifkan kembali dan pembelian dicatat';
                }

                // JIKA SUDAH AKTIF → TAMBAH STOK
                else {

                    $barang->update([
                        'jumlah'     => $barang->jumlah + $request->jumlah,
                        'harga_beli' => $request->harga_beli
                    ]);
                }
            }

            // JIKA BENAR-BENAR BELUM ADA
            else {

                $barang = DataBarang::create([
                    'id_kategori' => $request->id_kategori,
                    'nama_barang' => trim($request->nama_barang),
                    'harga_beli'  => $request->harga_beli,
                    'harga_jual'  => $request->harga_jual,
                    'jumlah'      => $request->jumlah,
                    'min_stok'    => $request->min_stok,
                    'status'      => 1
                ]);
            }

            $subtotal = $request->jumlah * $request->harga_beli;

            // DETAIL PEMBELIAN
            DetailPembelian::create([
                'id_data_barang'      => $barang->id,
                'id_pembelian'        => $pembelian->id,
                'jumlah'              => $request->jumlah,
                'harga_beli_baru'     => $request->harga_beli,
                'sub_total_pembelian' => $subtotal
            ]);

            // UPDATE TOTAL
            $pembelian->update([
                'total_pembelian' => $subtotal
            ]);
        });

        return redirect()->back()->with('success', $pesan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|max:200',
            'id_kategori' => 'required',
            'harga_jual'  => 'required|numeric',
            'min_stok'    => 'required|numeric|min:0'
        ]);

        $barang = DataBarang::findOrFail($id);
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'id_kategori' => $request->id_kategori,
            'harga_jual'  => $request->harga_jual,
            'min_stok'    => $request->min_stok
        ]);

        return redirect()->back()->with('success', 'Data barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $barang = DataBarang::findOrFail($id);
        $barang->update([
            'status' => 0
        ]);

        return redirect()->back()->with('success', 'Barang berhasil dihapus');
    }
}
