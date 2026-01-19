<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data_Barang extends Model
{
    protected $table = 'Data_Barang';
    public $incrementing = false; // Karena pakai UUID
    protected $keyType = 'string';
    public $timestamps = false; // Sesuaikan dengan struktur SQL Anda yang tidak pakai timestamps

    protected $fillable = [
        'id', 
        'id_kategori', 
        'nama_barang', 
        'harga_beli', 
        'harga_jual', 
        'jumlah'
    ];

    // Relasi: Barang ini "Milik" sebuah kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

     // untuk membua harga satuan
    public function getHargaSatuanAttribute()
    {
        // Mencegah pembagian dengan angka nol
        if ($this->jumlah > 0) {
            return $this->harga_beli / $this->jumlah;
        }
        return 0;
    }
}