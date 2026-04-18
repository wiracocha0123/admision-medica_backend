<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

route::apiResource('especialidades', App\Http\Controllers\EspecialidadesController::class);
Route::apiResource('pacientes', App\Http\Controllers\PacientesController::class);
Route::apiResource('operadores', App\Http\Controllers\OperadoresController::class);
Route::apiResource('personal_salud', App\Http\Controllers\PersonaSaludController::class);
Route::apiResource('citas', App\Http\Controllers\CitasController::class);