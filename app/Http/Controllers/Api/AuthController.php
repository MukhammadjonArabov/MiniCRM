<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6"
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        $token = $user->createToken("api_token")->plainTextToken;

        return response()->json([
            "message" => "User registered",
            "token" => $token,
            "user" => $user,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
        "password" => "required"
        ]);

        $user = User::where("email", $request->email)->first();

        if (! $user || !Hash::check($request->password, $user->password)) {
            return response()->json(["message" => "Invalid credentials"], 401);
        }

        $token = $user->createToken("api_token")->plainTextToken;

        return response()->json([
            "message" => "Logged in",
            "token" => $token,
            "user" => $user,
        ]);
    }

}

