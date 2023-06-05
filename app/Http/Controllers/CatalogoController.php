<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estampa;
use App\Models\Tshirt;
use App\Models\Categoria;
use App\Models\Precos;
use App\Models\Cor;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {

        $cores = Cor::all();

        $categorias = Categoria::all();

        $idcategoria = $request->idcategoria ?? 0;



        if($idcategoria==0){
            // $catalogo = Estampa::paginate(8);
            $catalogo = Estampa::paginate(8);

        }
        if($idcategoria!=0){
            //$catalogo = Estampa::paginate(8)->where('categoria_id',$idcategoria);
            $catalogo = Estampa::where('categoria_id',$idcategoria)->paginate(8);
        }

        $precoCatalogo = Precos::select('preco_un_catalogo')->get();
        $precoCatalogoDesconto = Precos::select('preco_un_catalogo_desconto')->get();
        $precoQuantidade = Precos::select('quantidade_desconto')->get();

        $precoCatalogo = $precoCatalogo[0]->preco_un_catalogo;
        $precoCatalogoDesconto = $precoCatalogoDesconto[0]->preco_un_catalogo_desconto;
        $precoQuantidade = $precoQuantidade[0]->quantidade_desconto;

        $request->session()->put('preco_un_catalogo',$precoCatalogo);
        $request->session()->put('preco_un_catalogo_desconto',$precoCatalogoDesconto);
        $request->session()->put('quantidade_desconto',$precoQuantidade);

        return view('catalogo.index')->with('catalogo',$catalogo)->with('cores',$cores)->with('categorias',$categorias)->with('idcategoria',$idcategoria);
    }
}
