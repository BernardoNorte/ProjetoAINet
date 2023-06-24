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

class EncomendaController extends Controller

{
    public function index(): View
    {

        $filterByID = $request->customer_id ?? 0;
        $filterByStatus = $encomenda->status ?? '';
        $filterByDate = $encomenda->date ?? '';
        $encomendaQuery = Encomenda::query();
        if ($filterByID !== null) {
            $encomendaQuery->where('customer_id', $filterByID);
        }

        if ($filterByStatus !== '') {
            $encomendaQuery->where('status', 'like', "%$filterByStatus%");
        }
        if ($filterByDate !== '') {
            $encomendaQuery->whereDate('date', $filterByDate);
        }
        $encomendas = Encomenda::paginate(5);
        return view('encomendas.index', compact('encomendas', 'filterByID', 'filterByStatus', 'filterByDate'))
            ->with('filterByDate', $filterByDate);

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


    public function __construct()
    {
        $this->authorizeResource(Encomenda::class, 'encomenda');
    }

}
