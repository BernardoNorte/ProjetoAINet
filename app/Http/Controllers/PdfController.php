<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encomenda;
use App\Models\Tshirt;
use App\Models\Cliente;
use App\Models\User;
use PDF;


class PdfController extends Controller
{
    public function index(Encomenda $encomenda){




        $tshirtsfilter = Tshirt::all()->where('encomenda_id', $encomenda['id']);

        $cliente = Cliente::all()->where('id',$encomenda['cliente_id']);

        $user= User::select('name','email')->where('id',$encomenda['cliente_id'])->get();

        $cliente = $cliente->toArray();

        $user = $user->toArray();

        $encomenda = $encomenda->toArray();

        $tshirtsfilter=$tshirtsfilter->toArray();


        $merged = array('encomenda' => $encomenda,
                        'tshirtsfilter' => $tshirtsfilter,
                        'cliente' => array_slice($cliente,0)[0],
                        'user' => $user[0]);

        $pdf = PDF::loadView('pdf.index',compact('merged'));

        return $pdf->download('Recibo de Encomenda nº'.$encomenda['id'].'.pdf');
    }


}
