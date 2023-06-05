<?php

namespace App\Http\Controllers;

use App\Models\Estampa;
use App\Http\Requests\EstampaPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EstampaController extends Controller
{
    public function index(){
        $estampas = Estampa::paginate(10);
        //dd($estampas);
        return view('estampas.index')->withEstampas($estampas);
    }

    public function edit(Estampa $estampa){

        return view('estampas.edit')->withEstampas($estampa);

    }

    public function update(EstampaPost $request, Estampa $estampa)
    {

        $validated_data = $request->validated();
        $estampa->nome = $validated_data['nome'];
        $estampa->descricao = $validated_data['descricao'];


        if($request->hasFile('imagem_url')){
            Storage::delete('public/estampas/' . $estampa->imagem_url);
            $path = $request->imagem_url->store('public/estampas');
            $estampa->imagem_url = basename($path);
        }

        $estampa->save();

        return redirect()->route('estampas.index')
            ->with('alert-msg', 'estampa "' . $estampa->nome . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }

}
