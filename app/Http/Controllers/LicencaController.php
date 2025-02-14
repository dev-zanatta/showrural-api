<?php

namespace App\Http\Controllers;

use App\Imports\EventTicketTypeExclusiveListImport;
use App\Models\Licenca;
use App\Models\Modalidade;
use App\Models\Monitoramento;
use GuzzleHttp\Client;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            ->select('monitoramentos.*', DB::raw('false as opened'), )
            ->get();

        return response()->json($licencas);
    }

    public function downloadPdf(Request $request)
    {

        Log::info($request);

        //send a post request
        $result = Http::post('http://localhost:3001/scrape', $request);

        $result = $result['data']['data'];

        Log::info($result);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Request error',
            ], 500);
        }

        $licenca = Licenca::where('n_protocolo', $result['numero_protocolo'])
            ->update(['pdf' => $result['pdf'], 'condicionamento' => $result['condicionamento']]);

        return $licenca;
    }

    protected function convertBase64ToFile(string $base64String, ?string $fileName = null): UploadedFile
    {
        if (!preg_match('/^data:([^;]+);base64,(.+)$/', $base64String, $matches)) {
            Log::info('erro');
        }

        $base64Content = $matches[2];

        $fileContent = base64_decode($base64Content, true);
        if ($fileContent === false) {
            Log::info('errrrrro');
        }

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

    public function allLicencasPorRazaoSocial(Request $request)
    {
        $licencas = Licenca::where('nome_razao_social', $request->razaoSocial)->get();

        return response()->json($licencas);
    }

    public function allModalidades()
    {
        $modalidades = Modalidade::all();

        return response()->json($modalidades);
    }

    public function novaModalidade(Request $request)
    {
        $modalidade = new Modalidade();
        $modalidade->sigla = $request->sigla;
        $modalidade->descricao = $request->descricao;
        $modalidade->save();

        return response()->json(['success' => true, 'modalidade' => $modalidade]);
    }

    public function gerarExcelComLicencas(Request $request)
    {
        $licencas = $request->licencas;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = array_keys($licencas[0]);
        $sheet->fromArray([$headers], null, 'A1');

        $rowIndex = 2;
        foreach ($licencas as $licenca) {
            $sheet->fromArray(array_values($licenca), null, "A{$rowIndex}");
            $rowIndex++;
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'licencas') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        $base64Excel = base64_encode(file_get_contents($tempFile));
        unlink($tempFile);

        return response()->json(['base64' => $base64Excel]);

    }
}
