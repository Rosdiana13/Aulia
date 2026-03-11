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
        $request->validate([
            'nama_pengguna' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('nama_pengguna', $request->nama_pengguna)
                    ->where('status', 1)
                    ->first();

        if ($user && $user->password == $request->password) {

            Auth::login($user);
            $request->session()->regenerate();

            return redirect('/dashboard')->with('login_success','Selamat Datang!');
        }

        return back()->withErrors([
            'nama_pengguna' => 'Username atau password salah'
        ]);
    }
    
    public function logout(Request $request)
    {
        
        Auth::logout();

        
        $request->session()->invalidate();

   
        $request->session()->regenerateToken();

       
        return redirect('/login');
    }
}