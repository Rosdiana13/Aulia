<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DetailPembelian extends Model
{
    protected $table = 'detail_pembelian';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_data_barang',
        'id_pembelian',
        'jumlah',
        'sisa_stok',
        'harga_beli_baru',
        'sub_total_pembelian'
    ];
}
