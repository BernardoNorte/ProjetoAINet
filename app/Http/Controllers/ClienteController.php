<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ClientePost;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use PDF;
use Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ClienteRequest;
use Illuminate\Support\Facades\DB;


class ClienteController extends Controller
{
    public function index(Request $request): View
    {
        $filterByNome = $request->nome ?? '';
        $clienteQuery = Cliente::query();
        if ($filterByNome !== ''){
            $clienteIds = cliente::where('name', 'like', "%$filterByNome%")->pluck('id');
            $clienteQuery->whereIntegerInRaw('id', $clienteIds);
        }
        $clientes = $clienteQuery->paginate(5);
        return view('clientes.index', compact('clientes', 'filterByNome'));
    }

    public function edit(Cliente $cliente): View
    {
        return view('clientes.edit')->withCliente($cliente);
    }

    public function update(ClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $formData = $request->validated();
        $cliente = DB::transaction(function () use ($formData, $cliente, $request){
            $cliente->nif = $formData['nif'];
            $cliente->address = $formData['address'];
            $cliente->default_payment_type = $formData['default_payment_type'];
            $cliente->default_payment_ref = $formData['default_payment_ref'];
            $cliente->save();
            $cliente = $cliente->cliente;
            $cliente->name = $formData['name'];
            $cliente->email = $formData['email'];
            $cliente->blocked = $formData['blocked'];
            $cliente->cliente_type = 'C';
            $cliente->save();
            if ($request->hasFile('file_foto')) {
                if ($cliente->cliente->photo_url){
                    Storage::delete('public/photos/' . $cliente->cliente->photo_url);
                }
                $path = $request->photo_url->store('public/photos');
                $cliente->cliente->photo_url = basename($path);
                $cliente->save();
            }
            return $cliente;
        });
        $url = route('clientes.show', ['cliente' => $cliente]);
        $htmlMessage = "Cliente <a href='$url'>#{$cliente->id}</a>
                        <strong>\"{$cliente->cliente->name}\"</strong> foi alterado com sucesso!";
        return redirect()->route('clientes.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy_foto(Cliente $cliente): RedirectResponse
    {
        if ($cliente->cliente->photo_url){
            Storage::delete('public/photos/' . $cliente->cliente->photo_url);
            $cliente->cliente->photo_url = null;
            $cliente->cliente->save();
        }

        return redirect()->route('clientes.edit', ['cliente' => $cliente])
            ->with('alert-msg', 'Cliente Photo "' . $cliente->cliente->name . '"was removed!')
            ->with('alert-type', ' Success');
    }

    public function show(Cliente $cliente): View
    {
        return view('clientes.show')->withCliente($cliente);
    }

    public function destroy(Cliente $cliente): RedirectResponse
    {
        try {
            $user = $cliente->user;
                DB::transaction(function () use ($cliente, $user) {
                    $cliente->delete();
                    $user->delete();
                });
                if ($cliente->user->photo_url) {
                    Storage::delete('public/fotos/' . $cliente->user->photo_url);
                }
                $htmlMessage = "cliente #{$cliente->id}
                        <strong>\"{$cliente->user->name}\"</strong> foi apagado com sucesso!";
                return redirect()->route('clientes.index')
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', 'success');
        } catch (\Exception $error) {
            $url = route('clientes.show', ['cliente' => $cliente]);
            $htmlMessage = "Não foi possível apagar o cliente <a href='$url'>#{$cliente->id}</a>
                        <strong>\"{$cliente->name}\"</strong> porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function __construct()
    {
        $this->authorizeResource(Cliente::class, 'cliente');
    }

}
