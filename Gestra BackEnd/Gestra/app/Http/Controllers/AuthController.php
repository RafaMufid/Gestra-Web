<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|max:200',
            'email' => 'required|email|max:200|unique:user_data',
            'password' => 'required|max:50',
            'user_type' => 'required|max:10',
        ]);

        $user = UserData::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Register successful',
            'token' => $token,
            'user' => $user
        ], 201);
    }

    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = UserData::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    // --- FUNGSI BARU YANG WAJIB DITAMBAHKAN ---

    // 1. GET PROFILE
    public function getProfile(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'user' => $user,
            'photo_url' => $user->profile_photo_path
                ? url('storage/' . $user->profile_photo_path) 
                : null,
        ]);
    }

    // 2. UPDATE PROFILE
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'username' => 'required|string|max:200',
            'email' => 'required|email|max:200|unique:user_data,email,'.$user->id,
            'password' => 'nullable|min:6',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user,
        ]);
    }

    // 3. UPDATE PHOTO
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();

        if ($request->hasFile('photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->profile_photo_path = $path;
            $user->save();

            return response()->json([
                'message' => 'Photo updated successfully',
                'photo_url' => url('storage/' . $path),
            ]);
        }

        return response()->json(['message' => 'No photo uploaded'], 400);
    }
}