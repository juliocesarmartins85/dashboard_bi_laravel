<?php

use App\Http\Controllers\DriverController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\NeighborhoodController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\StreetController;
use App\Http\Controllers\VehicleController;
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
    Route::put('/stops/update-vehicle', [HomeController::class, 'updateVehicle'])->name('stops.updateVehicle');
    Route::resource('logs', LogController::class);
    Route::resource('users', UserController::class);
    Route::resource('file', FileController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('sites', SiteController::class);
    Route::resource('profileusers', ProfileUserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('streets', StreetController::class);
    Route::resource('drivers', DriverController::class);
    Route::resource('routes', RouteController::class);
    Route::resource('neighborhoods', NeighborhoodController::class);
    Route::resource('stops', StopController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::post('/block_mac', [HomeController::class, 'block_mac'])->name('block_mac');
    Route::get('/config_user', [UserController::class, 'config_user'])->name('config_user');
    Route::post('/update_user/{id}', [UserController::class, 'update_user'])->name('update_user');
    /* Rotas para desenvolvimento. */
    Route::post('/db', [HomeController::class, 'db'])->name('db');
    Route::post('/mcrsf', [HomeController::class, 'mcrsf'])->name('mcrsf');
    Route::post('/clear_cache', [HomeController::class, 'clear_cache'])->name('clear_cache');
});
