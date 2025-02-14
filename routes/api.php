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
Route::get('/all-licencas-por-razao-social', [LicencaController::class, 'allLicencasPorRazaoSocial']);
Route::get('/all-modalidades', [LicencaController::class, 'allModalidades']);
Route::post('/nova-modalidade', [LicencaController::class, 'novaModalidade']);
Route::post('/gerar-excel-com-licencas', [LicencaController::class, 'gerarExcelComLicencas']);
