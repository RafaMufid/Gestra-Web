<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\UserData;

class ProfileWebController extends Controller
{
    public function index()
    {
        $user = Session::get("user");
        if (!$user) {
            return redirect()->route("login");
        }

        $photoUrl = $user["profile_photo_path"]
            ? rtrim(config("filesystems.disks.azure.url"), "/") .
                "/" .
                $user["profile_photo_path"]
            : asset("assets/default.png");

        return view("profile.index", compact("user", "photoUrl"));
    }

    public function update(Request $request)
    {
        if (!$request->expectsJson()) {
            return response()->json(["message" => "Invalid request"], 400);
        }

        $sessionUser = Session::get("user");
        if (!$sessionUser) {
            return response()->json(["message" => "Unauthorized"], 401);
        }

        $request->validate([
            "username" => "required|string|max:255",
            "email" => "required|email|max:255",
            "password" => "nullable|min:6",
            "photo" => "nullable|image|max:2048",
        ]);

        $user = UserData::find($sessionUser["id"]);
        if (!$user) {
            return response()->json(["message" => "User tidak ditemukan"], 404);
        }

        // Update text data
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled("password")) {
            $user->password = Hash::make($request->password);
        }

        // Upload foto ke Azure
        if ($request->hasFile("photo")) {
            // hapus foto lama
            if ($user->profile_photo_path) {
                Storage::disk("azure")->delete($user->profile_photo_path);
            }

            $path = $request->file("photo")->store("profile_photos", "azure");

            $user->profile_photo_path = $path;
        }

        $user->save();

        // Update session
        Session::put(
            "user",
            array_merge(Session::get("user"), [
                "username" => $user->username,
                "email" => $user->email,
                "profile_photo_path" => $user->profile_photo_path,
            ])
        );

        return response()->json([
            "message" => "Profile berhasil diperbarui",
            "user" => Session::get("user"),
        ]);
    }
}
