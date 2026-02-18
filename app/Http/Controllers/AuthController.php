<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        
        return view('login'); 
    }

   public function login(Request $request)
    {
        $credentials = $request->validate([
            'nama_pengguna' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['nama_pengguna' => $request->nama_pengguna, 'password' => $request->password, 'status' => 1])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('login_success', 'Selamat Datang!');
        }

        return back()->withErrors([
            'nama_pengguna' => 'Username salah atau password salah',
        ])->onlyInput('nama_pengguna');
    }

    public function showRegisterForm()
    {
        $semua_pengguna = \App\Models\User::where('status', 1)
                            ->orderBy('nama_pengguna', 'asc')
                            ->get();
        
        return view('pengguna', compact('semua_pengguna'));
    }

    
    public function logout(Request $request)
    {
        
        Auth::logout();

        
        $request->session()->invalidate();

   
        $request->session()->regenerateToken();

       
        return redirect('/login');
    }
}