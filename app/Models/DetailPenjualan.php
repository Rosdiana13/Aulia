<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_penjualan',
        'id_data_barang',
        'jumlah',
        'harga_saat_ini',
        'sub_total_penjualan'
    ];

    public function barang()
    {
        return $this->belongsTo(DataBarang::class, 'id_data_barang');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }
}
