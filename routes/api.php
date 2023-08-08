<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\TravelController;
use App\Http\Controllers\Api\UserController;
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

Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('roles', RoleController::class);

    Route::post('users', [UserController::class, 'store']);

    Route::put('travels/{id}', [TravelController::class, 'update']);
    Route::post('travels', [TravelController::class, 'store']);

    Route::post('tours', [TourController::class, 'store']);
});

Route::get('travels', [TravelController::class, 'index']);
Route::get('tours', [TourController::class, 'index']);
