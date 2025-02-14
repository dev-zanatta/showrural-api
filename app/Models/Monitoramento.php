<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Monitoramento extends Model
{
    //
    use SoftDeletes;

    public function monitoramentoLicencas()
    {
        return $this->hasMany(MonitoramentoLicencas::class, 'monitoramento_id', 'id')
            ->leftJoin('licencas', 'licencas.id', '=', 'monitoramento_licencas.licenca_id')
            ->select('licencas.*', 'monitoramento_licencas.id', 'monitoramento_licencas.monitoramento_id')
            ;
    }
}
