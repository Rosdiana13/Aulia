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
        'harga_beli_baru',
        'sub_total_pembelian'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function barang()
    {
        return $this->belongsTo(DataBarang::class, 'id_data_barang');
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }
}
