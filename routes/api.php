<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\EnvironmentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'store']);
Route::delete('/logout', [AuthController::class, 'destroy']);
Route::apiResource('/user', UserController::class)->only('store');

Route::apiResource('/user', UserController::class);
Route::apiResource('/card', CardController::class)->middleware('auth:sanctum');
Route::apiResource('/section', SectionController::class)->middleware('auth:sanctum');
Route::apiResource('/environment', EnvironmentController::class)->middleware('auth:sanctum');
