<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RubricController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/sanctum/login', [AuthController::class, 'login']);
Route::post('/users', [UserController::class, 'create']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/news', NewsController::class);
    Route::post('/rubrics',[RubricController::class, 'create']);
    Route::get('/rubrics', [RubricController::class, 'index']);
});

