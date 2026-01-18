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
        // Simpan ke Database
        Kategori::create([
            'id' => Str::uuid(), // Membuat ID unik otomatis (karena bukan auto-increment)
            'Nama_Kategori' => $request->Nama_Kategori,
        ]);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Menghapus kategori berdasarkan ID.
     */
    public function destroy($id)
    {
        // Cari kategori berdasarkan ID, jika ada langsung hapus
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}