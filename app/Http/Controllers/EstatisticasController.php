<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Support\Facades\DB;

class EstatisticasController extends Controller
{
    public function index()
    {
        $encomendasbymonthyear = DB::select('select concat(year(date)," ",MONTHNAME(date))  as yearmonth , SUM(total_price) as total from encomendas group by yearmonth');

        $counters = DB::select("SELECT
(select count(*) from clientes) as clientes,
       (Select count(*)  from encomendas) as encomendas,
         (Select count(*)  from estampas) as estampas,
         (Select count(*)  from cores) as cores
       ");

       $coresVendidas = DB::select('Select count(color_code) as value,concat("#",color_code) as color from tshirts group by color_code');

       $tipoPagamento = DB::select('select count(payment_ref) as cont,payment_ref from encomendas group by payment_ref');


        return view('estatisticas.index')->with('encomendasbymonthyear', $encomendasbymonthyear)
            ->with('counters', $counters[0])
            ->with('coresVendidas',$coresVendidas)
            ->with('tipoPagamento',$tipoPagamento);
    }
}
