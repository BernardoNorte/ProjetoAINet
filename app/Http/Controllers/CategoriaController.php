<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaPost;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index')->with('categorias', $categorias);
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit')->with('categoria',$categoria);
    }


    public function update(CategoriaPost $request, Categoria $categoria)
    {

        $validated_data = $request->validated();
        $categoria->nome = $validated_data['nome'];

        $categoria->save();

        return redirect()->route('categorias.index')
            ->with('alert-msg', 'categoria alterada com sucesso foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }
}
