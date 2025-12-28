<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthWebController extends Controller
{
    public function login(Request $request)
    {
        $response = Http::post('http://localhost:3000/api/users/login', [
            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($response->successful()) {
    $data = $response->json();

    Session::put('user', [
        'id' => $data['user']['id'],
        'username' => $data['user']['username'],
        'email' => $data['user']['email'],
        'profile_photo_path' => $data['user']['profile_photo_path'] ?? null,
        'token' => $data['token'],
    ]);

    return redirect('/home-after-login');
}

        return back()->with('error', 'Login gagal');
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/');
    }

    public function register(Request $request)
{
    // Validasi input
    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    // Kirim request ke API eksternal
    $response = Http::post('http://localhost:3000/api/users/register', [
        'username' => $request->username,
        'email' => $request->email,
        'password' => $request->password
    ]);

    if ($response->successful()) {
        // Bisa langsung login otomatis atau redirect ke login page
        return redirect('/login')->with('success', 'Akun berhasil dibuat, silakan login!');
    }

    // Jika gagal, kembali ke halaman register dengan error
    $errorMessage = $response->json()['message'] ?? 'Pendaftaran gagal';
    return back()->with('error', $errorMessage);
}

}
