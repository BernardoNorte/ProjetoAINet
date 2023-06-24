<?php

namespace App\Http\Controllers;

use App\Models\Estampa;
use App\Http\Requests\EstampaPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class EstampaController extends Controller
{
    public function index(){
        $estampas = Estampa::paginate(10);
        return view('estampas.index')->withEstampas($estampas);
    }

    public function edit(Estampa $estampa){

        return view('estampas.edit')->withEstampas($estampa);

    }

    public function update(EstampaPost $request, Estampa $estampa)
    {

        $validated_data = $request->validated();
        $estampa->nome = $validated_data['nome'];
        $estampa->descricao = $validated_data['descricao'];


        if($request->hasFile('imagem_url')){
            Storage::delete('public/estampas/' . $estampa->imagem_url);
            $path = $request->imagem_url->store('public/estampas');
            $estampa->imagem_url = basename($path);
        }

        $estampa->save();

        return redirect()->route('estampas.index')
            ->with('alert-msg', 'Tshirt "' . $estampa->nome . '" was changed with success!')
            ->with('alert-type', 'success');
    }

    public function destroy(Estampa $estampa): RedirectResponse
{
    try {
        $estampa->delete();

        // Remove a imagem associada à estampa, se existir
        if ($estampa->image_url) {
            Storage::delete('public/tshirt_images/' . $estampa->image_url);
        }

        $htmlMessage = "Estampa #{$estampa->id} \"{$estampa->name}\" foi apagada com sucesso!";
        return redirect()->route('catalogo.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    } catch (\Exception $error) {
        $url = route('catalogo.show', ['id' => $estampa->id]);
        $htmlMessage = "Não foi possível apagar a estampa <a href='$url'>#{$estampa->id}</a> \"{$estampa->name}\" porque ocorreu um erro!";
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'danger');
    }
}

}