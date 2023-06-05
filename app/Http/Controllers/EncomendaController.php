<?php

namespace App\Http\Controllers;

use App\Models\Encomenda;
use App\Models\Tshirt;
use App\Models\Cliente;
use App\Models\User;
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

        $encomendas = Encomenda::paginate(5);
        return view('encomendas.index', compact('encomendas'));

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
        return view('encomendas.edit')->withEncomenda($encomenda);
    }

    public function update(Request $request, Encomenda $encomenda): RedirectResponse
    {
        $encomenda->update($request->all());
        return redirect()->route('encomendas.index');
    }

    public function destroy(Encomenda $encomenda): RedirectResponse
    {
        $encomenda->delete();
        return redirect()->route('encomendas.index');
    }

    public function show(Encomenda $encomenda): View
    {
        return view('encomendas.show')->withEncomenda($encomenda);
    }


}
