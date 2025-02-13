<?php

use App\Http\Controllers\LicencaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/licencas', [LicencaController::class, 'index']);
Route::post('/cadastrar-novas-licencas', [LicencaController::class, 'novasLicencas']);
