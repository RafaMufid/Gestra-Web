<?php

namespace App\Http\Controllers;

use App\Models\Speech;
use Illuminate\Http\Request;

class SpeechController extends Controller
{
    // Pastikan route ini menggunakan middleware 'auth:sanctum' atau 'auth:api'
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'text' => 'required|string',
            'duration' => 'required|integer',
        ]);

        // Ambil user yang sedang login
        $user = $request->user(); 

        // Insert ke database
        $speech = Speech::create([
            'user_id' => $user->id,       // wajib karena kolom NOT NULL
            'text' => $validated['text'],
            'duration' => $validated['duration'],
        ]);

        // Response JSON
        return response()->json([
            'message' => 'Speech saved successfully',
            'data' => $speech
        ], 201);
    }
}