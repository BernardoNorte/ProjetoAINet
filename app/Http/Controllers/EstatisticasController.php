<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Support\Facades\DB;

class EstatisticasController extends Controller
{
    public function index()
    {
        $encomendasbymonthyear = DB::select('select concat(year(data)," ",MONTHNAME(data))  as yearmonth , SUM(preco_total) as total from encomendas group by yearmonth');

        $counters = DB::select("SELECT
(select count(*) from clientes) as clientes,
       (Select count(*)  from encomendas) as encomendas,
         (Select count(*)  from estampas) as estampas,
         (Select count(*)  from cores) as cores
       ");

       $coresVendidas = DB::select('Select count(cor_codigo) as value,concat("#",cor_codigo) as color from tshirts group by cor_codigo');

       $tipoPagamento = DB::select('select count(tipo_pagamento) as cont,tipo_pagamento from encomendas group by tipo_pagamento');


        return view('estatisticas.index')->with('encomendasbymonthyear', $encomendasbymonthyear)
            ->with('counters', $counters[0])
            ->with('coresVendidas',$coresVendidas)
            ->with('tipoPagamento',$tipoPagamento);
    }
}
