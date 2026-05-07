<?php

namespace App\Http\Controllers;


use App\Models\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Stop;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    /**
     * BUSCA POR LINHA ATRAVÉS DO NOME DA RUA
     * O usuário digita "Rua Direita" e o app retorna as linhas que passam nela.
     */
    public function searchByStreet(Request $request): JsonResponse
    {
        $request->validate(['query' => 'required|string|min:3']);
        $searchTerm = $request->query('query');

        // Busca ruas que coincidem com o termo e traz suas rotas vinculadas
        $routes = Route::whereHas('streets', function ($query) use ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%");
        })->get();

        return response()->json([
            'success' => true,
            'count' => $routes->count(),
            'data' => $routes
        ]);
    }

    /**
     * LOCALIZAÇÃO DOS ÔNIBUS EM TEMPO REAL
     * Retorna as coordenadas de todos os veículos ativos de uma linha específica.
     */
    public function getVehiclesLocation($routeId): JsonResponse
    {
        // Aqui buscamos os veículos vinculados às viagens (trips) ativas dessa rota
        $vehicles = Vehicle::whereHas('trips', function ($query) use ($routeId) {
            $query->where('route_id', $routeId);
        })->select('id', 'plate', 'model', 'current_lat', 'current_lng', 'last_update')
            ->get();

        return response()->json([
            'success' => true,
            'line_id' => $routeId,
            'vehicles' => $vehicles
        ]);
    }

    /**
     * BUSCA POR LINHA (NÚMERO OU NOME)
     * O usuário digita "101" ou "Hospital" e a API filtra os resultados.
     */
    public function searchByRoute(Request $request): JsonResponse
    {
        $request->validate(['query' => 'required|string|min:2']);
        $searchTerm = $request->query('query');

        $routes = Route::where('short_name', 'like', "%{$searchTerm}%") // Ex: "101"
            ->orWhere('long_name', 'like', "%{$searchTerm}%") // Ex: "Bairro Novo"
            ->get();

        return response()->json([
            'success' => true,
            'count' => $routes->count(),
            'data' => $routes
        ]);
    }

    /**
     * Busca um veículo específico pelo ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function vehicleId(int $id): JsonResponse
    {

        try {
            $vehicle = Vehicle::findOrFail($id);

            // Se o dado vier como string do banco, transformamos em array/objeto aqui
            if (is_string($vehicle->dataMoovsec)) {
                $vehicle->dataMoovsec = json_decode($vehicle->dataMoovsec);
            }

            return response()->json([
                'success' => true,
                'data' => $vehicle
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Veículo não encontrado.'
            ], 404);
        }
    }
    /**
     * Retorna todos os registros de paradas (stops).
     *
     * @return JsonResponse
     */
    public function stopsAll(): JsonResponse
    {
        // Busca todas as paradas do banco de dados
        $stops = Stop::all();

        return response()->json([
            'success' => true,
            'count' => $stops->count(),
            'data' => $stops
        ], 200);
    }
}
