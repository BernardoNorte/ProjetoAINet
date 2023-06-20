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

        $precoCatalogo = Precos::select('unit_price_catalog')->get();
        $precoCatalogoDesconto = Precos::select('unit_price_catalog_discount')->get();
        $precoQuantidade = Precos::select('qty_discount')->get();

        $precoCatalogo = $precoCatalogo[0]->unit_price_catalog;
        $precoCatalogoDesconto = $precoCatalogoDesconto[0]->unit_price_catalog_discount;
        $precoQuantidade = $precoQuantidade[0]->qty_discount;

        $request->session()->put('unit_price_catalog',$precoCatalogo);
        $request->session()->put('unit_price_catalog_discount',$precoCatalogoDesconto);
        $request->session()->put('qty_discount',$precoQuantidade);

        return view('catalogo.index')->with('catalogo',$catalogo)->with('cores',$cores)->with('categorias',$categorias)->with('idcategoria',$idcategoria);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Realiza a pesquisa pelo nome no banco de dados
        $results = Estampa::where('nome', 'like', '%' . $query . '%')->get();

        // Retorna a view catalogo.index com os resultados da pesquisa
        return view('catalogo.index', compact('query', 'results'));
    }

    public function show($id)
    {
        // Recupera o item do catálogo com base no ID
        $item = Estampa::find($id);
        $cores = Cor::all();

        // Verifiqua se o item foi encontrado
        if (!$item) {
            // Redireciona para uma página de erro ou retorne uma resposta adequada
            abort(404, 'Item not found');
        }

        // Retorna a view com os detalhes do item
        return view('catalogo.show', compact('item','cores'));
    }

}
