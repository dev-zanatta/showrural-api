<?php

namespace App\Http\Controllers;

use App\Models\Licenca;
use App\Models\Monitoramento;
use App\Models\MonitoramentoLicencas;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class MonitoramentoController extends Controller
{
    //
    public function create(Request $request)
    {
        $monitoramento = new Monitoramento();
        $monitoramento->razao_social = $request->razaoSocial;
        $monitoramento->save();

        $allLicencas = Licenca::where('nome_razao_social', $request->razaoSocial)->get();

        foreach($allLicencas as $licenca) {
            $monitoramentoLicenca = new MonitoramentoLicencas();
            $monitoramentoLicenca->licenca_id = $licenca->id;
            $monitoramentoLicenca->monitoramento_id = $monitoramento->id;
            $monitoramentoLicenca->save();
        }

        return response()->json(['success' => true, 'monitoramento' => $monitoramento]);
    }
}
