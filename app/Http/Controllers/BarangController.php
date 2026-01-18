<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_Barang;
use App\Models\Kategori;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    // MENAMPILKAN DATA
    public function index()
    {
        // Eager loading 'kategori' agar tidak berat saat load data
        $barang = Data_Barang::with('kategori')->get();
        $kategori = Kategori::all(); 
        
        return view('barang', compact('barang', 'kategori'));
    }

    public function store(Request $request)
    {
        $cekBarang = Data_Barang::where('nama_barang', $request->nama_barang)->first();

        if ($cekBarang) {
            // Jika ada, kembalikan dengan pesan error
            return back()->with('error', 'Barang dengan nama "' . $request->nama_barang . '" sudah terdaftar di sistem!');
        }
        
        Data_Barang::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'id_kategori' => $request->kategori, 
            'nama_barang' => $request->nama_barang,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'jumlah' => $request->stok,
        ]);

        return back()->with('success', 'Barang berhasil disimpan!');
    }

    // UPDATE DATA
    public function update(Request $request) {
        $barang = Data_Barang::findOrFail($request->id_barang);
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'jumlah' => $request->jumlah,
            'id_kategori' => $request->kategori
        ]);
        return back()->with('success', 'Data barang diperbarui!');
    }

    // HAPUS DATA
    public function destroy($id) {
        Data_Barang::destroy($id);
        return back()->with('success', 'Barang telah dihapus!');
    }
}