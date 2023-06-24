<?php

namespace App\Http\Controllers;

use App\Models\Encomenda;
use App\Models\Estampa;
use App\Models\Tshirt;
use App\Models\Cor;
use App\Models\Cliente;
use App\Models\User;
use App\Models\PdfController;
use Illuminate\Http\Request;
use PDF;
use Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class EncomendaController extends Controller

{
    public function index(Request $request): View
    {

        $filterStatus = $request->inputStatus ?? '';
        $filterNome = $request->nome ?? '';
        $filterDate = $request->date ?? '';
        $encomendaQuery = Encomenda::query();

        if ($filterStatus !== '') {
            $encomendaQuery->where('status', $filterStatus);
        }
        if ($filterNome !== ''){
            $userIds = User::where('name', 'like', "%$filterNome%")->pluck('id');
            $encomendaQuery->whereIntegerInRaw('customer_id', $userIds);
        }
        if ($filterDate !== ''){
            $encomendaQuery->where('date', $filterDate);
        }

        if($request->user()->user_type === 'E'){
            $encomendaQuery->whereIN('status', ['pending', 'paid']);
        }

        $encomendas = $encomendaQuery->paginate(5);
        return view('encomendas.index', compact('encomendas', 'filterStatus', 'filterNome', 'filterDate'));

    }

    public function minhasEncomendas(Request $request): View
    {
        $user_type = '';
        if ($request->user()) {
            $user_type = $request->user()->user_type ?? '';
        }
        if ($user_type == 'C') {
            $encomendas = $request->user()->cliente->encomendas;
        } else {
            $encomendas = Encomenda::paginate(5);
            return view('encomendas.index', compact('encomendas'));
        }
        return view('encomendas.minhas', compact('encomendas', 'user_type'));
    }

    public function create(): View
    {
        $newEncomenda = new Encomenda();
        return view('encomendas.create')->withEncomenda($newEncomenda);
    }

    public function store(Request $request): RedirectResponse
    {
        Encomenda::create($request->all());
        return redirect()->route('encomendas.index');
    }

    public function edit(Encomenda $encomenda): View
    {
        $tshirts = Tshirt::where('order_id', $encomenda->id)->get();
        
        return view('encomendas.edit', compact('encomenda', 'tshirts'));
    }

    public function update(Request $request, Encomenda $encomenda): RedirectResponse
    {
        $encomenda->update($request->all());
        return redirect()->route('encomendas.index');
    }

    public function show(Request $request, Encomenda $encomenda): View
    {
        $tshirts = Tshirt::where('order_id', $encomenda->id)->get();
        
        return view('encomendas.show', compact('encomenda', 'tshirts'));
    }

    public function statistics(): View
    {
        $AllOrdersByYear = Encomenda::select(DB::raw("YEAR(created_at) as year"),DB::raw("COUNT(*) as total_orders"))
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->orderBy(DB::raw("YEAR(created_at)"))
            ->get();

        $AllOrdersByStatus = Encomenda::select(DB::raw("status"),DB::raw("COUNT(*) as total_orders2"),)
            ->groupBy(DB::raw("status"))
            ->orderBy(DB::raw("status"))
            ->get();

        $years = $AllOrdersByYear->pluck('year')->all();
        $totalOrders = $AllOrdersByYear->pluck('total_orders')->all();
        $totalOrdersByStatus = $AllOrdersByStatus->pluck('total_orders2')->all();
        $status = $AllOrdersByStatus->pluck('status')->all();

        return view('encomendas.statistics', compact('years', 'totalOrders', 'totalOrdersByStatus', 'status'));
    }



    public function __construct()
    {
        $this->authorizeResource(Encomenda::class, 'encomenda');
    }

}
