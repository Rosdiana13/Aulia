<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        // Hanya tampilkan kategori yang masih aktif
        $kategori = Kategori::where('status', 1)->get();
        return view('kategori', compact('kategori'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'Nama_Kategori' => 'required|max:100'
        ]);

        // Cek apakah kategori sudah pernah ada
        $kategori = Kategori::where('Nama_Kategori', $request->Nama_Kategori)->first();

        // Jika ADA dan status = 0 → AKTIFKAN KEMBALI
        if ($kategori && $kategori->status == 0) {
            $kategori->update([
                'status' => 1
            ]);

            return redirect()->back()
                ->with('success', 'Kategori berhasil diaktifkan kembali');
        }

        // Jika ADA dan status = 1 → TOLAK
        if ($kategori && $kategori->status == 1) {
            return redirect()->back()
                ->withErrors(['Kategori sudah ada dan masih aktif']);
        }

        // Jika BELUM ADA → BUAT BARU
        Kategori::create([
            'Nama_Kategori' => $request->Nama_Kategori,
            'status'        => 1
        ]);

        return redirect()->back()
            ->with('success', 'Kategori berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        // Saat update: abaikan ID sendiri, tetap cek status aktif
        $request->validate([
            'Nama_Kategori' => 'required|max:100|unique:Kategori,Nama_Kategori,' . $id . ',id,status,1'
        ], [
            'Nama_Kategori.unique' => 'Kategori sudah ada dan masih aktif'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'Nama_Kategori' => $request->Nama_Kategori
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Soft delete manual: ubah status, bukan hapus data
        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'status' => 0
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil dinonaktifkan');
    }
}
