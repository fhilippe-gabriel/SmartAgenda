<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|string|email|unique:users',
        //     'password' => 'required|string|confirmed',
        // ]);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password),
        // ]);

        // return response()->json([
        //     'message' => 'User registered successfully',
        //     'status' => 201,
        //     'data' => $user,
        // ]);

        return response()->json([
            'message' => 'Voce chegou na rota de registro',
        ]);
    }
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);
    //     $user = User::where('email', $request->email)->first();

    //     if (!User || hash::check($request->password, $user->password)) {
    //         return response()->json([
    //             'message' => 'Invalid credentials',
    //             'status' => 401,
    //         ]);
    //     }
    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'message' => 'User logged in successfully',
    //         'status' => 200,
    //         'data' => [
    //             'user' => $user,
    //             'token' => $token,
    //         ],
    //     ]);
    // }
    // public function logout(Request $request)
    // {
    //     $request->user()->currentAccessToken()->delete();

    //     return response()->json([
    //         'message' => 'User logged out successfully',
    //         'user' => $request->user(),
    //         'status' => 200,
    //     ]);
    // }
    // public function me(Request $request)
    // {
    //     return response()->json([
    //         'message' => 'Data of usser logged in',
    //         'status' => 200,
    //         'data' => $request->user(),
    //     ]);
    // }
}
