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
            'user' => $user,
            'photo_url' => $user->photo ? url('storage/' . $user->photo) : null,
        ]);
    }

    // PROFILE
    public function profile(Request $request)
    {
        $authUser = auth()->guard('sanctum')->user();

        if (!$authUser) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user = \App\Models\UserData::find($authUser->id);

        return response()->json([
            'user' => $user,
            'photo_url' => $user->photo ? url('storage/' . $user->photo) : null,
        ]);
    }

    // UPDATE PROFIL
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'username' => 'required|max:200',
            'email' => 'required|email|max:200|unique:user_data,email,' . $user->id,
            'password' => 'required|max:50',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated',
            'user' => $user,
        ]);
    }

    //UPDATE FOTO
    public function updatePhoto(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('profile_photos', 'public');

        $user->photo = $path;
        $user->save();

        return response()->json([
            'message' => 'Photo updated',
            'photo_url' => url('storage/' . $path),
            'user' => $user,
        ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}

