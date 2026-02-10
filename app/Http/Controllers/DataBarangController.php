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

    /**
     * BARANG MASUK PERTAMA KALI
     * Dicatat sebagai pembelian
     */
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

        DB::transaction(function () use ($request) {

            // 1️⃣ PEMBELIAN (HEADER)
            $pembelian = Pembelian::create([
                'id_pengguna'     => auth()->user()->id, // WAJIB LOGIN
                'total_pembelian' => 0
            ]);

            // 2️⃣ CEK BARANG SUDAH ADA ATAU BELUM
            $barang = DataBarang::where('nama_barang', $request->nama_barang)
                ->where('id_kategori', $request->id_kategori)
                ->where('status', 1)
                ->first();

            // JIKA BELUM ADA → BUAT BARU
            if (!$barang) {
                $barang = DataBarang::create([
                    'id_kategori' => $request->id_kategori,
                    'nama_barang' => $request->nama_barang,
                    'harga_beli'  => $request->harga_beli,
                    'harga_jual'  => $request->harga_jual,
                    'jumlah'      => $request->jumlah,
                    'min_stok'    => $request->min_stok,
                    'status'      => 1
                ]);
            }
            // JIKA SUDAH ADA → TAMBAH STOK
            else {
                $barang->update([
                    'jumlah'     => $barang->jumlah + $request->jumlah,
                    'harga_beli' => $request->harga_beli
                ]);
            }

            $subtotal = $request->jumlah * $request->harga_beli;

            // 3️⃣ DETAIL PEMBELIAN
            DetailPembelian::create([
                'id_data_barang'      => $barang->id,
                'id_pembelian'        => $pembelian->id,
                'jumlah'              => $request->jumlah,
                'harga_beli_baru'     => $request->harga_beli,
                'sub_total_pembelian' => $subtotal
            ]);

            // 4️⃣ UPDATE TOTAL PEMBELIAN
            $pembelian->update([
                'total_pembelian' => $subtotal
            ]);
        });

        return redirect()->back()
            ->with('success', 'Barang berhasil ditambahkan dan pembelian dicatat');
    }

    /**
     * EDIT DATA BARANG
     * (tanpa ubah stok)
     */
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

    /**
     * NONAKTIFKAN BARANG
     */
    public function destroy($id)
    {
        $barang = DataBarang::findOrFail($id);
        $barang->update([
            'status' => 0
        ]);

        return redirect()->back()->with('success', 'Barang berhasil dinonaktifkan');
    }
}
