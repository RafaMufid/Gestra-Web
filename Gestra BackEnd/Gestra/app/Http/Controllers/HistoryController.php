<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LearningHistory;

class HistoryController extends Controller
{
    // Fungsi untuk MENYIMPAN data dari Flutter
    public function store(Request $request)
    {
        // 1. Validasi data yang dikirim
        $request->validate([
            'gesture_name' => 'required|string', // Contoh: "SAYA MAKAN"
            'accuracy' => 'required|numeric',    // Contoh: 1.0
            'source' => 'required|in:camera,speech',
        ]);

        $user = $request->user(); // Ambil user yang sedang login

        // 2. Simpan ke Database
        $history = LearningHistory::create([
            'user_id' => $user->id,
            'gesture_name' => $request->gesture_name,
            'accuracy' => $request->accuracy,
            'source' => $request->source,
        ]);

        // 3. Beri balasan ke Flutter bahwa "Sukses" (Kode 201)
        return response()->json([
            'message' => 'History saved successfully!',
            'data' => $history
        ], 201);
    }

    // Fungsi tambahan: Melihat riwayat user (Opsional)
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $today = LearningHistory::where('user_id', $userId)
        ->whereDate('created_at', now())
        ->orderBy('created_at', 'desc')
        ->get();

        $previous = LearningHistory::where('user_id', $userId)
            ->whereDate('created_at', '<', now())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'today' => $today,
            'previous' => $previous,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $history = LearningHistory::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $history->delete();

        return response()->json([
            'message' => 'History deleted successfully'
        ]);
    }

}