<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [ApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [ApiController::class, 'userInfo']);
    Route::post('logout', [ApiController::class, 'logOut']);
    // Busca específica por rua
    Route::get('/search/street', [ApiController::class, 'searchByStreet']);
    // Busca específica por número ou nome da linha
    Route::get('/search/route', [ApiController::class, 'searchByRoute']);
    // Mapa: Localização dos veículos da linha selecionada
    Route::get('/map/route/{id}/vehicles', [ApiController::class, 'getVehiclesLocation']);
    // Rota para buscar veículo por ID
    Route::get('/vehicles/{id}', [ApiController::class, 'vehicleId']);
    // Rota para buscar todas as paradas
    Route::get('/stops', [ApiController::class, 'stopsAll']);
});
