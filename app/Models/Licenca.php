<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Licenca extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'n_protocolo',
        'cpf_cnpj',
        'nome_razao_social',
        'atividade',
        'atividade_especifica',
        'cidade',
        'uf',
        'modalidade',
        'n_documento',
        'data_emissao',
        'data_validade',
        'dias_vencimento',
        'meses_vencimento',
        'anos_vencimento',
    ];
}
