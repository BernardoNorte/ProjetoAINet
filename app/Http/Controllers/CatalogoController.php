<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estampa;
use App\Models\Tshirt;
use App\Models\Categoria;
use App\Models\Precos;
use App\Models\Cor;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\EstampaRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CatalogoController extends Controller
{

    public function index(Request $request): View
    {

        $cores = Cor::all();
        $idcategoria = $request->idcategoria ?? 0;
        $filterByNome = $request->name ?? '';
        $filterByCategoria = $request->categoria ?? '';
        $filterByDescricao = $request->description ?? '';
        $estampaQuery = Estampa::query();
        $categorias = Categoria::all();
    
        if ($idcategoria != 0) {
            $estampaQuery->where('category_id', $idcategoria);
        }
    
        if ($filterByCategoria !== '') {
            $estampaQuery->where('category_id', $filterByCategoria);
        }

        if ($filterByDescricao !== ''){
            $estampaQuery->where('description',$filterByDescricao);
        }
    
        if ($filterByNome !== '') {
            $estampaQuery->where('name', 'like', "%$filterByNome%");
        }
    
        $estampas = $estampaQuery->with('categoria')->paginate(8);
    
        $precoCatalogo = Precos::select('unit_price_catalog')->get();
        $precoCatalogoDesconto = Precos::select('unit_price_catalog_discount')->get();
        $precoQuantidade = Precos::select('qty_discount')->get();
    
        $precoCatalogo = $precoCatalogo[0]->unit_price_catalog;
        $precoCatalogoDesconto = $precoCatalogoDesconto[0]->unit_price_catalog_discount;
        $precoQuantidade = $precoQuantidade[0]->qty_discount;
    
        $request->session()->put('unit_price_catalog', $precoCatalogo);
        $request->session()->put('unit_price_catalog_discount', $precoCatalogoDesconto);
        $request->session()->put('qty_discount', $precoQuantidade);
    
        return view('catalogo.index', compact('estampas', 'categorias', 'filterByNome', 'filterByCategoria','filterByDescricao'))
            ->with('catalogo', $estampas)
            ->with('cores', $cores)
            ->with('categorias', $categorias)
            ->with('idcategoria', $idcategoria);
    }
    public function show($id)
    {
        // Recupera o item do catálogo com base no ID
        $item = Estampa::find($id);
        $cores = Cor::all();

        // Verifiqua se o item foi encontrado
        if (!$item) {
            // Redireciona para uma página de erro ou retorne uma resposta adequada
            abort(404, 'Item not found');
        }

        // Retorna a view com os detalhes do item
        return view('catalogo.show', compact('item','cores'));
    }

    public function add($id)
    {
        $estampa = Estampa::find($id);
        $estampas = Estampa::all();
        return view('catalogo.create', compact('estampa', 'estampas'));
    }

    public function edit($id)
    {
        $estampa = Estampa::find($id);
        $estampas = Estampa::all();
        return view('catalogo.edit', compact('estampa', 'estampas'));
    }

    public function update (EstampaRequest $request, Estampa $estampa): RedirectResponse
    {
        $formData = $request->validated();
        $novaEstampa = DB::transaction(function () use ($formData, $estampa, $request) {
            $estampa->name = $formData['name'];
            $estampa->description = $formData['description'];
            $estampa->image_url = 'default_image.png';
            
            $estampa->save();
            
            if ($request->hasFile('image_url')) {
                if ($estampa->image_url) {
                    Storage::delete('public/tshirt_images/' . $estampa->image_url);
                }
                $path = $request->image_url->store('public/tshirt_images');
                $estampa->image_url = basename($path);
                $estampa->save();
            } 

            $estampa->save();

            return $estampa;
        });
        $url = route('catalogo.show', ['id' => $novaEstampa->id, 'allowUpload' => false]);
        $htmlMessage = "A estampa <a href='$url'>#{$novaEstampa->id}</a>
                        <strong>\"{$novaEstampa->name}\"</strong> foi alterada com sucesso!";
        return redirect()->route('catalogo.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function store(EstampaRequest $request, Estampa $estampa)
    {

        $validated_data = $request->validated();
        $estampa->name = $validated_data['name'];
        $estampa->description = $validated_data['description'];


        if($request->hasFile('image_url')){
            Storage::delete('public/tshirt_images/' . $estampa->image_url);
            $path = $request->image_url->store('public/tshirt_images');
            $estampa->image_url = basename($path);
        }

        $estampa->save();

        return redirect()->route('catalogo.index')
            ->with('alert-msg', 'estampa "' . $estampa->name . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }

/*    public function destroy($id)
{
    $estampa = Estampa::find($id);

    if ($estampa) {
        // Exclua o registro
        $estampa->delete();

        // Redirecione para a página desejada após a exclusão
        return redirect()->route('catalogo.index')->with('success', 'Estampa excluída com sucesso.');
    }

    // Caso o registro não seja encontrado, retorne uma resposta adequada
    return redirect()->route('catalogo.index')->with('error', 'Estampa não encontrada.');
}*/


    public function destroy_image(Estampa $estampa): RedirectResponse
    {
        if ($estampa->image_url){
            Storage::delete('public/tshirt_images/' . $estampa->image_url);
            $estampa->image_url = null;
            $estampa->save();
        }

        return redirect()->route('catalogo.edit', ['catalogo' => $estampa])
            ->with('alert-msg', 'Tshirt Photo "' . $estampa->name . '"was removed!')
            ->with('alert-type', ' Success');
    }

}

