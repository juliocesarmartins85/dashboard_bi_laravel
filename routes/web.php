<?php

use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\EnqueteController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\HotspotController;
use App\Http\Controllers\RouterBoardController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PerguntasController;
use App\Http\Controllers\RouterBoardUserAtivoController;
use App\Http\Controllers\RouterBoardUserController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\WifiFreeController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('web.home');
Route::get('/wifi_free/{mac}', [WifiFreeController::class, 'wifi_free'])->name('wifi_free');
Route::post('/wifi_free_conectar', [WifiFreeController::class, 'wifi_free_conectar'])->name('wifi_free_conectar');
Route::get('/clear_cache', [WifiFreeController::class, 'clear_cache'])->name('clear_cache');
Route::get('/mcrsf/{nome}', [WifiFreeController::class, 'mcrsf'])->name('mcrsf');
//
Auth::routes();
//
Route::get('/home', [HomeController::class, 'index'])->name('home');
///
Route::group(['middleware' => ['auth']], function () {
    //Route::resource('products', ProductController::class);
    Route::resource('logs', LogController::class);
    Route::resource('user', UserController::class);
    Route::resource('file', FileController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('sites', SiteController::class);
    Route::resource('hotspot', HotspotController::class);
    Route::resource('enquetes', EnqueteController::class);
    Route::resource('enderecos', EnderecoController::class);
    Route::resource('perguntas', PerguntasController::class);
    Route::resource('blacklists', BlacklistController::class);
    Route::resource('routerboard', RouterBoardController::class);
    Route::resource('routerboarduser', RouterBoardUserController::class);
    Route::resource('routerboarduserativo', RouterBoardUserAtivoController::class);
    Route::resource('profileusers', ProfileUserController::class);
    Route::resource('products', ProductController::class);
    Route::post('/block_mac', [HomeController::class, 'block_mac'])->name('block_mac');
    Route::get('/config_user', [UserController::class, 'config_user'])->name('config_user');
    Route::post('/update_user/{id}', [UserController::class, 'update_user'])->name('update_user');
    Route::get('/router_dash/{id}', [RouterBoardController::class, 'router_dash'])->name('router_dash');
    Route::get('/clients_conectados/{id}', [HomeController::class, 'clientsconnects'])->name('clientsconnects');
    Route::get('/ipBindingAdd/{id}/{idrb}/{cmd}', [RouterBoardController::class, 'ipBindingAdd'])->name('ipBindingAdd');
    Route::get('/ipBindingRemove/{id}/{idrb}', [RouterBoardController::class, 'ipBindingRemove'])->name('ipBindingRemove');
    /* Rotas para desenvolvimento. */
    Route::post('/db', [WifiFreeController::class, 'db'])->name('db');
    Route::post('/mcrsf', [WifiFreeController::class, 'mcrsf'])->name('mcrsf');
    Route::post('/clear_cache', [WifiFreeController::class, 'clear_cache'])->name('clear_cache');
});
