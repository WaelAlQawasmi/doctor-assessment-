<?php

use App\Http\Controllers\Api\AuthController;
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

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::get('/auth/get-all-users', [AuthController::class, 'getAllusers'])->middleware('auth:sanctum');
Route::get('/auth/getUsrById/{id}', [AuthController::class, 'getUsrById'])->middleware('auth:sanctum');
Route::get('/auth/getUsrByname/{name}', [AuthController::class, 'getUsrByName'])->middleware('auth:sanctum');
