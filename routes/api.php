<?php

use App\Http\Controllers\LicencaController;
use App\Http\Controllers\MonitoramentoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/licencas', [LicencaController::class, 'index']);
Route::post('/cadastrar-novas-licencas', [LicencaController::class, 'novasLicencas']);
Route::post('/baixar-pdf', [LicencaController::class, 'downloadPdf']);
Route::post('/novo-monitoramento', [MonitoramentoController::class, 'create']);

Route::get('/licencas-organizadas', [LicencaController::class, 'licencasComMonitoramento']);
