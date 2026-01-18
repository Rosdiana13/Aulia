<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // Nama tabel sesuai database Anda
    protected $table = 'Kategori'; 

    // Karena id menggunakan UUID, matikan auto-increment
    public $incrementing = false;
    protected $keyType = 'string';

    // Kolom yang boleh diisi manual
    protected $fillable = ['id', 'Nama_Kategori'];

    // Jika tabel Anda tidak memiliki kolom created_at & updated_at
    public $timestamps = false; 

    // Relasi ke Data Barang (Satu kategori punya banyak barang)
    public function barang()
    {
        return $this->hasMany(Data_Barang::class, 'id_kategori', 'id');
    }
}