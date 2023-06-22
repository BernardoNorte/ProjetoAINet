<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estampa;
use App\Models\Tshirt;
use App\Models\Categoria;
use App\Models\Precos;
use App\Models\Cor;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\CatalogoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CatalogoController extends Controller
{

    public function index(Request $request): View
    {

        $cores = Cor::all();
        $idcategoria = $request->idcategoria ?? 0;
        $filterByNome = $request->name ?? '';
        $filterByCategoria = $request->categoria ?? '';
        $filterByDescricao = $request->description ?? '';
        $estampaQuery = Estampa::query();
        $categorias = Categoria::all();
    
        if ($idcategoria != 0) {
            $estampaQuery->where('category_id', $idcategoria);
        }
    
        if ($filterByCategoria !== '') {
            $estampaQuery->where('category_id', $filterByCategoria);
        }

        if ($filterByDescricao !== ''){
            $estampaQuery->where('description',$filterByDescricao);
        }
    
        if ($filterByNome !== '') {
            $estampaQuery->where('name', 'like', "%$filterByNome%");
        }
    
        $estampas = $estampaQuery->with('categoria')->paginate(8);
    
        $precoCatalogo = Precos::select('unit_price_catalog')->get();
        $precoCatalogoDesconto = Precos::select('unit_price_catalog_discount')->get();
        $precoQuantidade = Precos::select('qty_discount')->get();
    
        $precoCatalogo = $precoCatalogo[0]->unit_price_catalog;
        $precoCatalogoDesconto = $precoCatalogoDesconto[0]->unit_price_catalog_discount;
        $precoQuantidade = $precoQuantidade[0]->qty_discount;
    
        $request->session()->put('unit_price_catalog', $precoCatalogo);
        $request->session()->put('unit_price_catalog_discount', $precoCatalogoDesconto);
        $request->session()->put('qty_discount', $precoQuantidade);
    
        return view('catalogo.index', compact('estampas', 'categorias', 'filterByNome', 'filterByCategoria','filterByDescricao'))
            ->with('catalogo', $estampas)
            ->with('cores', $cores)
            ->with('categorias', $categorias)
            ->with('idcategoria', $idcategoria);
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
