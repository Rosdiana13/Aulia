<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori; // Pastikan Model Kategori sudah dibuat
use Illuminate\Support\Str; // Alat untuk membuat UUID otomatis

class KategoriController extends Controller
{
    /**
     * Menampilkan halaman kategori dan daftar datanya.
     */
    public function index()
    {
        // Mengambil semua data kategori dari database
        $kategori = Kategori::all();
        
        // Mengirim data ke view kategori.blade.php
        return view('kategori', compact('kategori'));
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Ubah input user jadi huruf kecil semua
        $inputNama = strtolower($request->Nama_Kategori);

        // 2. Cek di database dengan merubah isi kolom Nama_Kategori jadi kecil semua juga
        $cekDuplikat = Kategori::whereRaw('LOWER(Nama_Kategori) = ?', [$inputNama])->exists();

        if ($cekDuplikat) {
            // Jika kedeteksi sama, balikkan pesan error
            return redirect()->back()->with('error', "Kategori '$request->Nama_Kategori' sudah ada!");
        }

        // 3. Jika benar-benar baru, baru simpan
        Kategori::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'Nama_Kategori' => $request->Nama_Kategori,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambah!');
    }

    /**
     * Menghapus kategori berdasarkan ID.
     */
    public function destroy($id)
    {
        // 1. Cari kategori berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // 2. Cek apakah ada barang yang terhubung (menggunakan relasi barang() di Model)
        if ($kategori->barang()->exists()) {
            // Jika ada, kirim pesan error dan batalkan penghapusan
            return redirect()->back()->with('error', 
                "Gagal menghapus! Kategori '{$kategori->Nama_Kategori}' masih memiliki data barang di dalamnya. Hapus atau pindahkan data barang terlebih dahulu."
            );
        }

        // 3. Jika tidak ada relasi, hapus kategori
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}