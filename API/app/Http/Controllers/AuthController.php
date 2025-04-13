<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
        ]);

        // 🔍 Verifica se já existe um usuário com o email informado
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            // ⚠️ Se o email já estiver cadastrado, retorna erro
            return response()->json([
                'message' => 'Email já está vinculado a um usuário existente',
                'status' => 409,
            ], 409); // 409 Conflict
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'status' => 201,
            'data' => $user,
        ]);

        // return response()->json([
        //     'message' => 'Voce chegou na rota de registro',
        // ]);
    }


    public function login(Request $request)
    {
        // 🛡️ Validação dos campos obrigatórios
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // 🔍 Busca o usuário pelo email
        $user = User::where('email', $request->email)->first();

        // ❌ Se o usuário não existir ou a senha estiver incorreta
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciais inválidas', // mensagem amigável
                'status' => 401,
            ], 401);
        }

        // 🔑 Gera um token de autenticação Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // ✅ Retorna os dados do usuário autenticado e o token
        return response()->json([
            'message' => 'Login realizado com sucesso',
            'status' => 200,
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User logged out successfully',
            'user' => $request->user(),
            'status' => 200,
        ]);
    }
    public function me(Request $request)
    {
        return response()->json([
            'message' => 'Data of usser logged in',
            'status' => 200,
            'data' => $request->user(),
        ]);
    }
}
