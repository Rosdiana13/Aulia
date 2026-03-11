<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualanBatch extends Model
{
    protected $table = 'detail_penjualan_batch';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_detail_penjualan',
        'id_detail_pembelian',
        'qty_diambil'
    ];
}