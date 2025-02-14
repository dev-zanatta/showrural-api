<?php

namespace App\Imports;

use App\Models\Licenca;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class EventTicketTypeExclusiveListImport implements
    ToCollection,
    WithHeadingRow,
    SkipsEmptyRows

{
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            [$cidade, $uf] = explode('/', $row['municipio_uf']);
            Licenca::create(
                // [
                //     'n_protocolo' => $row['no_protocolo'],
                // ],
                [
                    'n_protocolo' => $row['no_protocolo'],
                    'cpf_cnpj' => $row['cpf_cnpj'],
                    'nome_razao_social' => $row['nome_razao_social'],
                    'atividade' => $row['atividade'],
                    'atividade_especifica' => $row['atividade_especifica'],
                    'cidade' => $cidade,
                    'uf' => $uf,
                    'modalidade' => $row['modalidade'],
                    'n_documento' => $row['no_documento'],
                    'data_emissao' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(str_replace("'", $row['dt_emissao'], ""))),
                    'data_validade' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(str_replace("'", $row['dt_validade'], ""))),
                    'dias_vencimento' => $row['dias_para_vencimento'],
                    'meses_vencimento' => $row['meses'],
                    'anos_vencimento' => $row['anos'],
                ]
            );
        }
    }
}
