<?php

namespace App\Http\Controllers;


use App\Models\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Api $api)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Api $api)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Api $api)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Api $api)
    {
        //
    }
    /**
     * Registro de novo usuário com login automático.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // Adicionei 'confirmed' para segurança
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Usuário registrado com sucesso',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
            ]
        ], 201);
    }

    /**
     * Autenticação e geração de token.
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'As credenciais fornecidas estão incorretas.'
            ], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Opcional: Deletar tokens antigos para garantir apenas um login ativo por vez
        // $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login realizado com sucesso',
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]
        ]);
    }

    /**
     * Retorna os dados do usuário autenticado.
     */
    public function userInfo(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()
        ]);
    }

    /**
     * Revoga o token atual do usuário.
     */
    public function logOut(Request $request): JsonResponse
    {
        // Deleta apenas o token que está sendo usado na requisição atual
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sessão encerrada com sucesso'
        ]);
    }
}
