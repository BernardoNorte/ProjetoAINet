<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ClientePost;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ClienteController extends Controller
{
    public function index(Request $request): View
    {
        $filterByNome = $request->nome ?? '';
        $clienteQuery = Cliente::query();
        if ($filterByNome !== ''){
            $userIds = User::where('name', 'like', "%$filterByNome%")->pluck('id');
            $clienteQuery->whereIntegerInRaw('id', $userIds);
        }
        $clientes = $clienteQuery->paginate(5);
        return view('clientes.index', compact('clientes', 'filterByNome'));
    }

    public function edit(Cliente $cliente)
    {

        return view('clientes.edit')->withCliente($cliente);
    }

    public function update(ClientePost $request, Cliente $cliente)
    {

        $validated_data = $request->validated();
        $cliente->user->name = $validated_data['name'];
        $cliente->user->email = $validated_data['email'];
        $cliente->nif = $validated_data['nif'];
        $cliente->endereco = $validated_data['endereco'];
        $cliente->tipo_pagamento = $validated_data['tipo_pagamento'];
        $cliente->ref_pagamento = $validated_data['ref_pagamento'];
        $cliente->user->bloqueado = $validated_data['bloqueado'];


        if ($request->hasFile('foto_url')) {
            Storage::delete('public/fotos/' . $cliente->user->foto_url);
            $path = $request->foto_url->store('public/fotos');
            $cliente->user->foto_url = basename($path);
            $cliente->user->save();
        }
        $cliente->user->save();

        $cliente->save();
        return redirect()->route('clientes.index')
            ->with('alert-msg', 'cliente "' . $cliente->user->name . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function show(Cliente $cliente): View
    {
        return view('clientes.show')->withCliente($cliente);
    }

}
