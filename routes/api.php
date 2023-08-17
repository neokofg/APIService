<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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
Route::middleware('auth:sanctum')->get('user', [AuthController::class, 'user']);

// Роуты авторизации -->
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::get('unauthorized', 'unauthorized')->name('unauthorized');
});
// <--

// Роуты продуктов -->
Route::prefix('product')->controller(ProductController::class)->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('buy', 'buy');
        Route::patch('update', 'update');
        Route::post('rent', 'rent');
    });
    Route::get('index', 'index');
    Route::get('find', 'find');
});
// <--
