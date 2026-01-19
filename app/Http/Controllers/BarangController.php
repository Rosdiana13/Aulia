<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_Barang;
use App\Models\Kategori;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    // MENAMPILKAN DATA
    public function index(Request $request)
    {
        $search = $request->input('search');

        $barang = Data_Barang::with('kategori')
            ->when($search, function($query) use ($search) {
                // Kita bungkus dalam grup 'where' agar logika OR tidak bertabrakan dengan filter lain
                $query->where(function($q) use ($search) {
                    $q->where('nama_barang', 'like', '%' . $search . '%')
                    ->orWhereHas('kategori', function($cat) use ($search) {
                        $cat->where('Nama_Kategori', 'like', '%' . $search . '%');
                    });
                });
            })
            ->get();

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
        
        // Hapus harga_beli dan jumlah agar tidak bisa dimanipulasi manual
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'harga_jual'  => $request->harga_jual,
            'id_kategori' => $request->kategori
        ]);
        
        return back()->with('success', 'Data barang diperbarui!');
    }

    public function destroy($id) {
    // 1. Cari data barang berdasarkan ID
    $barang = Data_Barang::find($id);

    // 2. Cek apakah barang ditemukan
    if (!$barang) {
        return back()->with('error', 'Data barang tidak ditemukan!');
    }

    // 3. Cek apakah stok (jumlah) lebih dari 0
    // Sesuaikan nama kolom 'jumlah' dengan yang ada di database Anda (misal: 'stok')
    if ($barang->jumlah > 0) {
        return back()->with('error', 'Barang tidak bisa dihapus karena masih ada stok (' . $barang->jumlah . ')!');
    }

    // 4. Jika stok 0, maka hapus
    $barang->delete();

    return back()->with('success', 'Barang telah dihapus!');
}
}