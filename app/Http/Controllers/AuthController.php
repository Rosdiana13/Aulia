<?php

// NAMESPACE: Ibarat 'Alamat Rumah' file ini.
// Menunjukkan bahwa file AuthController berada di dalam folder app/Http/Controllers.
// Ini membantu Laravel agar tidak bingung jika ada nama file yang sama di folder lain.
namespace App\Http\Controllers;

/**
 * IMPORT CLASS (Pernyataan 'use'):
 * Ibarat mengambil 'Peralatan' dari gudang Laravel agar bisa dipakai di file ini.
 */

// Mengambil alat 'Request' untuk menangkap data yang diketik user di form (seperti input username/password).
use Illuminate\Http\Request;

// Mengambil alat 'Auth' yang berisi fungsi keamanan bawaan Laravel 
// seperti mengecek password, login, dan logout.
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * FUNGSI: Menampilkan halaman login.
     * Penjelasan: Fungsi ini bekerja sebagai 'Gatekeeper' awal. Ketika user mengakses 
     * alamat web/login, fungsi inilah yang akan memanggil tampilan (UI) login.
     */
    public function index()
    {
        // Mencari file di resources/views/login.blade.php untuk ditampilkan ke browser
        return view('login'); 
    }

    /**
     * FUNGSI: Memproses verifikasi data login.
     * Penjelasan: Fungsi ini menerima data dari form di view, mengecek ke database, 
     * dan membuatkan 'tiket masuk' (Session) jika datanya cocok.
     */
    public function login(Request $request)
    {
        // 1. Validasi: Filter awal untuk memastikan user tidak mengirim data kosong ke server.
        // Jika kosong, sistem akan langsung menolak.
        $credentials = $request->validate([
            'nama_pengguna' => 'required|string',
            'password' => 'required|string',
        ]);

        /**
         * 2. Autentikasi Utama:
         * Laravel secara cerdas membandingkan password teks biasa dari form 
         * dengan password Bcrypt (acak) yang ada di database menggunakan 'Auth::attempt'.
         */
        if (Auth::attempt(['nama_pengguna' => $request->nama_pengguna, 'password' => $request->password])) {
            
            /**
             * 3. Keamanan Sesi (Session Fixation):
             * Kita membuat ID session baru setelah login berhasil 
             * agar hacker yang memegang ID session lama tidak bisa masuk ke akun user.
             */
            $request->session()->regenerate();

            /**
             * 4. Pengalihan (Redirect):
             * Mengirim user ke dashboard. 'intended' artinya jika tadi user mencoba buka 
             * halaman laporan tapi dipaksa login, maka setelah login ia otomatis ke laporan.
             * 'with' mengirim pesan sukses yang hanya muncul satu kali (Flash Message).
             */
            return redirect()->intended('/dashboard')->with('login_success', 'Selamat Datang! Anda berhasil login ke sistem Toko Aulia.');
        }

        /**
         * 5. Logika Gagal: 
         * Jika password/username salah, kita kembalikan user ke posisi semula.
         * 'onlyInput' menjaga agar nama yang sudah diketik tidak hilang (user-friendly).
         */
        return back()->withErrors([
            'nama_pengguna' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('nama_pengguna');
    }

    /**
     * FUNGSI: Mengakhiri sesi pengguna secara aman.
     * Penjelasan: Tidak hanya sekedar keluar, fungsi ini membersihkan semua jejak 
     * digital di server agar akun tidak bisa dibajak setelah logout.
     */
    public function logout(Request $request)
    {
        // Menghapus status 'Authenticated' pada sistem Laravel
        Auth::logout();

        // Menghapus seluruh data session yang tersimpan di server untuk user ini
        $request->session()->invalidate();

        // Mengganti token CSRF agar sesi berikutnya memiliki kunci keamanan yang baru
        $request->session()->regenerateToken();

        // Melempar user kembali ke halaman login
        return redirect('/login');
    }
}