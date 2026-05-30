<?php

namespace App\Http\Controllers;
use App\Models\DataBarang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataBarangController extends Controller
{
    public function index()
    {
            $barang = DB::table('data_barang as db')
            ->leftJoin('kategori as k', 'db.id_kategori', '=', 'k.id')
            ->select(
                'db.*',
                'k.Nama_Kategori',
                DB::raw('
                    (
                        (SELECT COALESCE(SUM(dp2.jumlah),0)
                        FROM detail_pembelian dp2
                        WHERE dp2.id_data_barang = db.id)
                        - db.jumlah
                    ) as stok_terjual
                ')
            )
            ->where('db.status', 1)
            ->get();

        $kategori = Kategori::where('status', 1)->get();

        return view('barang', compact('barang', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|max:200',
            'id_kategori' => 'required',
            'harga_beli'  => 'required|numeric|min:1',
            'harga_jual'  => 'required|numeric|min:1|gte:harga_beli',
            'jumlah'      => 'required|numeric|min:1',
            'min_stok'    => 'required|numeric|min:1'
        ], [
            'harga_jual.gte' => 'Harga jual tidak boleh lebih kecil dari harga beli'
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
            'harga_jual'  => 'required|numeric|min:1',
            'min_stok'    => 'required|numeric|min:1'
        ]);

        try {

            $barang = DataBarang::findOrFail($id);

            if ($request->harga_jual < $barang->harga_beli) {
                return redirect()->back()
                    ->with('error', 'Harga jual tidak boleh lebih kecil dari harga beli');
            }

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

    public function history($id)
    {
        $data = DB::table('v_history_pembelian')
            ->where('id_data_barang', $id)
            ->orderBy('tanggal_beli', 'asc')
            ->get();

        return view('history_pembelian', compact('data'));
    }

    public function exportExcel()
    {
        $data = DB::table('data_barang as db')
            ->select(
                'db.nama_barang',
                'db.jumlah as sisa_stok',
                DB::raw('
                    (
                        (SELECT COALESCE(SUM(dp2.jumlah),0)
                        FROM detail_pembelian dp2
                        WHERE dp2.id_data_barang = db.id)
                        - db.jumlah
                    ) as stok_terjual
                ')
            )
            ->where('db.status', 1)
            ->get();

        $filename = "laporan-stok.xls";

        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$filename"
        ];

        return response()
            ->view('export_barang_excel', compact('data'))
            ->withHeaders($headers);
    }
}
