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
}
