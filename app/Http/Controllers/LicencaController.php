<?php

namespace App\Http\Controllers;

use App\Imports\EventTicketTypeExclusiveListImport;
use App\Models\Licenca;
use App\Models\Monitoramento;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class LicencaController extends Controller
{
  //
  public function index()
  {
    $licencas = Licenca::select(
        'licencas.*',
        DB::raw("CONCAT(licencas.anos_vencimento, ' anos e ', licencas.meses_vencimento, ' meses') as vence_em"),
        DB::raw("CONCAT(licencas.cidade, ' / ', licencas.uf) as cidade_uf"),
        )

        ->get();

    return response()->json($licencas);
  }

  public function novasLicencas(Request $request)
  {
    try {
      DB::beginTransaction();

      $file = $this->convertBase64ToFile($request->base64excel);
      Excel::import(new EventTicketTypeExclusiveListImport(), $file);

      DB::commit();
    } catch (\Throwable $th) {
      DB::rollBack();
      Log::info($th);
    }
  }

  public function licencasComMonitoramento()
  {
    $licencas = Monitoramento::with('monitoramentoLicencas')
        ->select('monitoramentos.*', DB::raw('false as opened'))
        ->get();

    return response()->json($licencas);
  }

  protected function convertBase64ToFile(string $base64String, ?string $fileName = null): UploadedFile
    {
        if (!preg_match('/^data:([^;]+);base64,(.+)$/', $base64String, $matches)) {
            Log::info('erro');
        }

        $mimeType = $matches[1];
        $base64Content = $matches[2];

        $fileContent = base64_decode($base64Content, true);
        if ($fileContent === false) {
            Log::info('errrrrro');
        }

        // $extension = $this->getExtensionFromMimeType($mimeType);

        $fileName = $fileName ?? uniqid('file_', true);
        $fullFileName = "{$fileName}.xlsx";

        $tempPath = sys_get_temp_dir() . '/' . $fullFileName;
        if (file_put_contents($tempPath, $fileContent) === false) {
            Log::info('dasdasdasd');
        }

        return new UploadedFile(
            $tempPath,
            $fullFileName,
            null,
            null,
            true
        );
    }
}
