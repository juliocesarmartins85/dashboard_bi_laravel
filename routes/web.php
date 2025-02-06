<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BreadcrumbsController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('breadcrumbs', BreadcrumbsController::class);
    Route::resource('products', ProductController::class);
    Route::resource('profile', ProfileUserController::class);
    Route::resource('file', FileController::class);
});
