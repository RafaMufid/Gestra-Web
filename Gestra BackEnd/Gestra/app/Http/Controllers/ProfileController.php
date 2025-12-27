<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'user' => $user,
            'photo_url' => $user->profile_photo_path
                ? rtrim(config('filesystems.disks.azure.url'), '/') . '/' . ltrim($user->profile_photo_path, '/')
                : null,
            ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'username' => 'required|string|max:200',
            'email' => 'required|email|max:200|unique:user_data,email,'.$user->id,
            'password' => 'nullable|min:6|max:50',
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

    public function updatePhoto(Request $request) {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();

        if ($request->hasFile('photo')) {

            if ($user->profile_photo_path) {
                Storage::disk('azure')->delete($user->profile_photo_path);
            }

            $path = Storage::disk('azure')->put(
                'profile_photos',
                $request->file('photo')
            );

            $user->profile_photo_path = $path;
            $user->save();

            return response()->json([
                'message' => 'Photo updated successfully',
                'photo_path' => $path,
            ]);
        }

    return response()->json(['message' => 'No photo uploaded'], 400);
    }
}