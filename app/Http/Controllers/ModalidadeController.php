<?php

namespace App\Http\Controllers;

use App\Models\Modalidade;
use Illuminate\Http\Request;

class ModalidadeController extends Controller
{
    //

    public function all()
    {
        $modalidades = Modalidade::all();

        return response()->json($modalidades);
    }

    public function create(Request $request)
    {
        $modalidade = new Modalidade();
        $modalidade->sigla = $request->sigla;
        $modalidade->descricao = $request->descricao;
        $modalidade->save();

        return response()->json(['success' => true, 'modalidade' => $modalidade]);
    }
}
