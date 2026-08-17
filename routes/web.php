<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SiteController;
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
//
Auth::routes();
//
Route::get('/home', [HomeController::class, 'index'])->name('home');
///
Route::group(['middleware' => ['auth']], function () {
    Route::resource('logs', LogController::class);
    Route::resource('users', UserController::class);
    Route::resource('file', FileController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('sites', SiteController::class);
    Route::resource('profileusers', ProfileUserController::class);
    Route::resource('products', ProductController::class);
    Route::post('/block_mac', [HomeController::class, 'block_mac'])->name('block_mac');
    Route::get('/config_user', [UserController::class, 'config_user'])->name('config_user');
    Route::post('/update_user/{id}', [UserController::class, 'update_user'])->name('update_user');
    /* Rotas para desenvolvimento. */
    Route::post('/db', [HomeController::class, 'db'])->name('db');
    Route::post('/mcrsf', [HomeController::class, 'mcrsf'])->name('mcrsf');
    Route::get('/clear_cache', [HomeController::class, 'clear_cache'])->name('clear_cache');
});
