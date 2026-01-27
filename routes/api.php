<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('jwt.auth')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('marca/all', [MarcaController::class, 'all']);
    Route::apiResource('cliente', ClienteController::class);
    Route::apiResource('carro', CarroController::class);
    Route::apiResource('locacao', LocacaoController::class);
    Route::apiResource('marca', MarcaController::class);
    Route::apiResource('modelo', ModeloController::class);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);
