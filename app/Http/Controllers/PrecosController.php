<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Precos;
use App\Http\Requests\PrecosPost;

class PrecosController extends Controller
{
    public function index()
    {
       $precos=Precos::all();

        return view('precos.index')->with('precos',$precos);
    }

    public function update(PrecosPost $request, Precos $precos)
    {
        $precos->delete();

        $validated_data = $request->validated();

        $precos->preco_un_catalogo = $validated_data['preco_un_catalogo'];
        $precos->preco_un_proprio = $validated_data['preco_un_proprio'];
        $precos->preco_un_catalogo_desconto = $validated_data['preco_un_catalogo_desconto'];
        $precos->preco_un_proprio_desconto = $validated_data['preco_un_proprio_desconto'];
        $precos->quantidade_desconto = $validated_data['quantidade_desconto'];

        $precos = Precos::findOrFail(1);
        $precos->fill($validated_data);

        $precos->save();

        return redirect()->route('precos.index')
            ->with('alert-msg', 'Precos foram alterados alterado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function reset()
    {
        $precos = Precos::findOrFail(1);

        $precos->preco_un_catalogo = 10.00;
        $precos->preco_un_proprio = 15.00;
        $precos->preco_un_catalogo_desconto = 8.50;
        $precos->preco_un_proprio_desconto = 12.00;
        $precos->quantidade_desconto = 5;

        $precos->save();

        return redirect()->route('precos.index')
            ->with('alert-msg', 'Precos foram resetados com sucesso!')
            ->with('alert-type', 'success');
    }
}

