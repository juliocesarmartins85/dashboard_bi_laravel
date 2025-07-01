<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
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

Route::post('/wifi_pro', [ApiController::class, 'wifi_pro'])->name('wifi_pro');
Route::post('/auth/login', [ApiController::class, 'loginUser']);
Route::get('/traficorb/{rb}/{interface}', [ApiController::class, 'traficorb'])->name('traficorb');
//Route::get('/cidadesDigitais', [ApiController::class, 'cidadesDigitais'])->name('cidadesDigitais');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/migrations', [ApiController::class, 'migrations'])->name('migrations');
    Route::get('/password_reset_tokens', [ApiController::class, 'password_reset_tokens'])->name('password_reset_tokens');
    Route::get('/users', [ApiController::class, 'users'])->name('users');
    Route::get('/password_resets', [ApiController::class, 'password_resets'])->name('password_resets');
    Route::get('/failed_jobs', [ApiController::class, 'failed_jobs'])->name('failed_jobs');
    Route::get('/personal_access_tokens', [ApiController::class, 'personal_access_tokens'])->name('personal_access_tokens');
    Route::get('/permissions', [ApiController::class, 'permissions'])->name('permissions');
    Route::get('/model_has_permissions', [ApiController::class, 'model_has_permissions'])->name('model_has_permissions');
    Route::get('/roles', [ApiController::class, 'roles'])->name('roles');
    Route::get('/model_has_roles', [ApiController::class, 'model_has_roles'])->name('model_has_roles');
    Route::get('/role_has_permissions', [ApiController::class, 'role_has_permissions'])->name('role_has_permissions');
    Route::get('/products', [ApiController::class, 'products'])->name('products');
    Route::get('/breadcrumbs', [ApiController::class, 'breadcrumbs'])->name('breadcrumbs');
    Route::get('/perguntas', [ApiController::class, 'perguntas'])->name('perguntas');
    Route::get('/enquetes', [ApiController::class, 'enquetes'])->name('enquetes');
    Route::get('/respostas', [ApiController::class, 'respostas'])->name('respostas');
    Route::get('/hotspots', [ApiController::class, 'hotspots'])->name('hotspots');
    Route::get('/pergunta_respostas', [ApiController::class, 'pergunta_respostas'])->name('pergunta_respostas');
    Route::get('/router_boards', [ApiController::class, 'router_boards'])->name('router_boards');
    Route::get('/side_bars', [ApiController::class, 'side_bars'])->name('side_bars');
    Route::get('/blacklists', [ApiController::class, 'blacklists'])->name('blacklists');
    Route::get('/device_histories', [ApiController::class, 'device_histories'])->name('device_histories');
    Route::get('/files', [ApiController::class, 'files'])->name('files');
    Route::get('/webs', [ApiController::class, 'webs'])->name('webs');
    Route::get('/logs', [ApiController::class, 'logs'])->name('logs');
    Route::get('/profile_users', [ApiController::class, 'profile_users'])->name('profile_users');
    Route::get('/enderecos', [ApiController::class, 'enderecos'])->name('enderecos');
    Route::get('/sites', [ApiController::class, 'sites'])->name('sites');
    Route::get('/banners', [ApiController::class, 'banners'])->name('banners');
    Route::get('/blogs', [ApiController::class, 'blogs'])->name('blogs');
    Route::get('/contacts', [ApiController::class, 'contacts'])->name('contacts');
    Route::get('/diretiva_privacidades', [ApiController::class, 'diretiva_privacidades'])->name('diretiva_privacidades');
    Route::get('/docs', [ApiController::class, 'docs'])->name('docs');
    Route::get('/features', [ApiController::class, 'features'])->name('features');
    Route::get('/galleries', [ApiController::class, 'galleries'])->name('galleries');
    Route::get('/heroes', [ApiController::class, 'heroes'])->name('heroes');
    Route::get('/menus', [ApiController::class, 'menus'])->name('menus');
    Route::get('/politica_cookies', [ApiController::class, 'politica_cookies'])->name('politica_cookies');
    Route::get('/pricings', [ApiController::class, 'pricings'])->name('pricings');
    Route::get('/protecao_dados', [ApiController::class, 'protecao_dados'])->name('protecao_dados');
    Route::get('/rede_socials', [ApiController::class, 'rede_socials'])->name('rede_socials');
    Route::get('/apis', [ApiController::class, 'apis'])->name('apis');
    Route::get('/router_board_user_ativos', [ApiController::class, 'router_board_user_ativos'])->name('router_board_user_ativos');
    Route::get('/router_board_users', [ApiController::class, 'router_board_users'])->name('router_board_users');
    Route::get('/dataSeed/{tb}', [ApiController::class, 'dataSeed'])->name('dataSeed');
});


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//7CiRDHgRkJUJKNh&NfpuR4rM2W9yQ!nPn8mTdS#Hj%Uiao4WHCbRCyYb47#Yps5cQzCAf2uEdqURj
