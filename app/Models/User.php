<?php

namespace App\Models;

// Mengambil alat 'Authenticatable' agar file ini punya kemampuan fitur Login/Keamanan.
use Illuminate\Foundation\Auth\User as Authenticatable;
// Mengambil alat 'Notifiable' agar sistem bisa mengirimkan notifikasi jika diperlukan.
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * PENGATURAN TABEL DATABASE
     */
    
    // Memberitahu Laravel bahwa nama tabel di database adalah 'Pengguna', bukan 'users'.
    protected $table = 'Pengguna'; 

    // Memberitahu bahwa kolom kunci utama (Primary Key) bernama 'id'.
    protected $primaryKey = 'id';

    // Karena id pakai UUID (string acak), 
    // kita set 'false' agar Laravel tidak otomatis menganggapnya angka yang bertambah sendiri.
    public $incrementing = false;

    // Memberitahu bahwa tipe data Primary Key adalah teks (string), bukan angka (integer).
    protected $keyType = 'string';

    // Kita set 'false' jika tabel kita tidak punya kolom otomatis 'created_at' dan 'updated_at'.
    public $timestamps = false; 

    /**
     * PENGATURAN DATA
     */

    // Daftar kolom yang 'BOLEH' diisi secara massal (untuk keamanan agar tidak ada kolom rahasia yang terisi).
    protected $fillable = [
        'id', 'nama_pengguna', 'password', 'jabatan',
    ];

    /**
     * LOGIKA LOGIN KHUSUS
     */

    // INI PENTING: Secara standar, Laravel mencari kolom 'email' untuk login.
    // Karena di Toko Aulia kita pakai 'nama_pengguna', fungsi ini wajib ada 
    // untuk memberitahu Laravel: "Eh, carinya di kolom nama_pengguna ya!"
    public function getAuthIdentifierName()
    {
        return 'nama_pengguna';
    }
}