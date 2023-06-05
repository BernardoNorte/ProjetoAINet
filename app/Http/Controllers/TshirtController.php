<?php

namespace App\Http\Controllers;

use App\Models\Tshirt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF;

class TshirtController extends Controller
{
    // public function index()
    // {
    //     $tshirts = Tshirt::all();
    //     //$nomeEst = DB::table('tshirts')->join('estampas', 'tshirts.estampa_id', '=', 'estampas.id')->select('estampas.imagem_url')->where($id, 'estampas.id')->get();
    //     return view('tshirts.index')->with('tshirts', $tshirts);
    // }

    public function indexfilter($encomenda_id)
    {
        $tshirtsfilter = Tshirt::all()->where('encomenda_id', $encomenda_id);

        //$nomeEst = DB::table('tshirts')->join('estampas', 'tshirts.estampa_id', '=', 'estampas.id')->select('estampas.imagem_url')->where($id, 'estampas.id')->get();
        return view('tshirts.index')->with('tshirts', $tshirtsfilter);
    }
}
