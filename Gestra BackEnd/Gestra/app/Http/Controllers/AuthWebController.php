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
            Session::put('user', $response->json()['user']);
            return redirect('/home-after-login');
        }

        return back()->with('error', 'Login gagal');
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/');
    }
}
