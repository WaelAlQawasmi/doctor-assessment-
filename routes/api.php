<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\QuestionController;
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
Route::get('/auth/get-all-users', [AuthController::class, 'getAllusers'])->middleware('auth:sanctum');;
Route::get('/auth/getUsrById/{id}', [AuthController::class, 'getUsrById'])->middleware('auth:sanctum');
Route::get('/auth/getUsrByname/{name}', [AuthController::class, 'getUsrByName'])->middleware('auth:sanctum');

Route::get('/auth/check-logged-in-user', [AuthController::class, 'checkLoggedInUser'])->middleware('auth:sanctum');
Route::post('/auth/logout', [AuthController::class, 'logout'])-> middleware('auth:sanctum');

Route::post('/questions/create', [QuestionController::class, 'store'])-> middleware('auth:sanctum');
Route::get('/questions/{id}', [QuestionController::class, 'show'])-> middleware('auth:sanctum');
Route::get('/all', [QuestionController::class, 'showAll'])->middleware('auth:sanctum');
Route::put('/questions/update/{id}', [QuestionController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->middleware('auth:sanctum');
// Route::resource('questions', QuestionController::class)->middleware('auth:sanctum');