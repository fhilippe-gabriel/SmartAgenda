<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registrar um novo usuário",
     *     description="Registra um novo usuário no sistema.",
     *     operationId="register",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="João Silva"),
     *             @OA\Property(property="email", type="string", format="email", example="joao@exemplo.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário registrado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registered successfully"),
     *             @OA\Property(property="status", type="integer", example=201),
     *             @OA\Property(property="data", ref="#/components/schemas/User") 
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Email já está vinculado a um usuário existente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Email já está vinculado a um usuário existente"),
     *             @OA\Property(property="status", type="integer", example=409)
     *         )
     *     )
     * )
     */

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
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Realizar login de um usuário",
     *     description="Autentica um usuário e gera um token de autenticação.",
     *     operationId="login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="joao@exemplo.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login realizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login realizado com sucesso"),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", ref="#/components/schemas/User"),
     *                 @OA\Property(property="token", type="string", example="your_generated_token")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Credenciais inválidas"),
     *             @OA\Property(property="status", type="integer", example=401)
     *         )
     *     )
     * )
     */

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


    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Realizar logout de um usuário",
     *     description="Desloga um usuário e revoga o token de autenticação.",
     *     operationId="logout",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Usuário deslogado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User logged out successfully"),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User logged out successfully',
            'user' => $request->user(),
            'status' => 200,
        ]);
    }
    /**
     * @OA\Get(
     *     path="/api/me",
     *     summary="Retornar dados do usuário logado",
     *     description="Retorna os dados do usuário autenticado.",
     *     operationId="me",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Dados do usuário logado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data of user logged in"),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function me(Request $request)
    {
        return response()->json([
            'message' => 'Data of usser logged in',
            'status' => 200,
            'data' => $request->user(),
        ]);
    }
}
