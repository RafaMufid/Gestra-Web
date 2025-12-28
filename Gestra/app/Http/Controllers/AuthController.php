<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $request->validate([
            'username'      => 'required|max:200',
            'email'     => 'required|email|max:200|unique:user_data',
            'password'  => 'required|min:6|max:50',
            'user_type' => 'required|max:10',
        ]);

        $user = UserData::create([
            'username'      => $request->username,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'user_type' => $request->user_type,
        ]);

        // Simpan user ke session agar langsung login
        session(['user' => $user]);

        return redirect('/')->with('success', 'Register berhasil, selamat datang!');
    }

    
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = UserData::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Email atau password salah'
            ]);
        }

        // Simpan user ke session
        session(['user' => $user]);

        // Redirect ke homepage Blade
        return redirect('/')->with('success', 'Login berhasil');
    }

  
    public function logout()
    {
        session()->forget('user');

        return redirect('/login')->with('success', 'Berhasil logout');
    }
}
