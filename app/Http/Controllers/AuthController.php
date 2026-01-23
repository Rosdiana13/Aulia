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
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        $credentials = $request->validate([
            'nama_pengguna' => 'required|string',
            'password' => 'required|string',
        ]);

        // Tambahkan 'status' => 1 agar pengguna non-aktif tidak bisa masuk
        if (Auth::attempt(['nama_pengguna' => $request->nama_pengguna, 'password' => $request->password, 'status' => 1])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('login_success', 'Selamat Datang!');
        }

        return back()->withErrors([
            'nama_pengguna' => 'Username salah, password salah, atau akun Anda dinonaktifkan.',
        ])->onlyInput('nama_pengguna');
    }

    public function showRegisterForm()
    {
        // Mengambil data pengguna yang HANYA berstatus aktif
        // Diurutkan berdasarkan nama agar rapi
        $semua_pengguna = \App\Models\User::where('status', 1)
                            ->orderBy('nama_pengguna', 'asc')
                            ->get();
        
        // Kirim data ke view 'pengguna'
        return view('pengguna', compact('semua_pengguna'));
    }

    public function register(Request $request)
    {
        // 1. Validasi input (Hapus 'unique' agar tidak error saat input nama yang sudah ada di database)
        $request->validate([
            'nama_pengguna' => 'required',
            'password' => 'required|min:5',
            'jabatan' => 'required'
        ]);

        // 2. Cek apakah username sudah pernah terdaftar sebelumnya
        $userAda = User::where('nama_pengguna', $request->nama_pengguna)->first();

        if ($userAda) {
            if ($userAda->status == 0) {
                // Jika akun ada tapi non-aktif, kita aktifkan kembali (Reactivate)
                $userAda->update([
                    'password' => Hash::make($request->password),
                    'jabatan' => $request->jabatan,
                    'status' => 1 // Aktifkan lagi
                ]);
                return back()->with('success', 'Akun lama berhasil diaktifkan kembali!');
            } else {
                // Jika akun ada dan masih aktif, beri pesan error
                return back()->with('error', 'Nama pengguna sudah terpakai dan masih aktif.');
            }
        }

        // 3. Jika benar-benar baru, buat baris baru
        User::create([
            'id' => (string) Str::uuid(),
            'nama_pengguna' => $request->nama_pengguna,
            'password' => Hash::make($request->password),
            'jabatan' => $request->jabatan,
            'status' => 1,
        ]);

        return back()->with('success', 'Pengguna baru berhasil didaftarkan!');
    }

    public function destroy($id)
    {
        // Cari pengguna berdasarkan ID
        $user = User::find($id);

        if ($user) {
            // Jangan dihapus permanen, cukup ubah status ke 0
            $user->update(['status' => 0]);
            
            return back()->with('success', 'Akun pengguna telah dinonaktifkan (Data transaksi tetap aman).');
        }

        return back()->with('error', 'Data pengguna tidak ditemukan.');
    }

    // Fusngsi untuk mengakhiri sesi
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