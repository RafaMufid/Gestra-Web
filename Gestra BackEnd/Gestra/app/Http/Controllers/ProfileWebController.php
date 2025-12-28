<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\UserData;

class ProfileWebController extends Controller
{
    public function index()
    {
        $user = Session::get('user');

        if (!$user) {
            return redirect('/login');
        }

        $photoUrl = null;
        if (!empty($user['profile_photo_path'])) {
            $photoUrl =
                rtrim(config('filesystems.disks.azure.url'), '/') . '/' .
                ltrim($user['profile_photo_path'], '/');
        }

        return view('profile.index', [
            'user' => $user,
            'photoUrl' => $photoUrl
        ]);
    }

    public function update(Request $request)
    {
        $user = Session::get('user');

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();

            $userData = UserData::find($user['id']);

            if ($userData->profile_photo_path) {
                Storage::disk('azure')->delete($userData->profile_photo_path);
            }

            $path = Storage::disk('azure')->put('profile_photos', $file);

            $userData->profile_photo_path = $path;
            $userData->save();

            $user['profile_photo_path'] = $path;
            Session::put('user', $user);
        }

        $payload = [
            'username' => $request->username,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $payload['password'] = $request->password;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . ($user['token'] ?? ''),
        ])->post('http://localhost:3000/api/users/profile/update', $payload);

        if (!$response->successful()) {
            return response()->json([
                'message' => 'Gagal update profile',
                'status' => $response->status(),
                'body' => $response->json(),
            ], 400);
        }

        $updatedUser = $response->json()['user'];

        Session::put('user', [
            'id' => $updatedUser['id'],
            'username' => $updatedUser['username'],
            'email' => $updatedUser['email'],
            'profile_photo_path' => $user['profile_photo_path'] ?? null, 
            'token' => $user['token'],
        ]);

        return response()->json([
            'message' => 'Profile updated',
            'user' => Session::get('user')
        ], 200);
    }
}
