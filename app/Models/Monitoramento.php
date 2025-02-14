<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Monitoramento extends Model
{
    //
    use SoftDeletes;

    public function monitoramentoLicencas()
    {
        return $this->hasMany(MonitoramentoLicencas::class, 'monitoramento_id', 'id')
            ->leftJoin('licencas', 'licencas.id', '=', 'monitoramento_licencas.licenca_id')
            ->select('licencas.*', 'monitoramento_licencas.id', 'monitoramento_licencas.monitoramento_id', DB::raw("
            CASE
                WHEN EXTRACT(DAY FROM AGE(licencas.data_validade)) <= 120 THEN 'Baixo'
                WHEN EXTRACT(DAY FROM AGE(licencas.data_validade)) BETWEEN 121 AND 150 THEN 'Médio'
                WHEN EXTRACT(DAY FROM AGE(licencas.data_validade)) BETWEEN 151 AND 180 THEN 'Alto'
                ELSE 'Sem risco'
            END as risco
        ")
        )
            ;
    }
}
