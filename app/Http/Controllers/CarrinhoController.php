<?php

namespace App\Http\Controllers;

use App\Models\Estampa;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Encomenda;
use Illuminate\Support\Facades\Auth;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use App\Http\Requests\EncomendaPost;
use App\Http\Requests\TshirtPost;
use App\Models\Tshirt;
use PDF;

class CarrinhoController extends Controller
{
    public function show(): View
    {
        $cart = session('cart', []);
        return view('cart.show', compact('cart'));
    }

    public function addToCart(Request $request, Estampa $estampa): RedirectResponse
    {
        $userType = $request->user()->user_type ?? 'C';
        if ($userType == 'A' || $userType == 'E'){
            $alertType = 'warning';
            $htmlMessage = "The user is not a client or anonymous, therefore he cannot add a tshirt to the cart!";
        }else{
            /*$clienteID = $request->user()->cliente->id;
            $totalEstampas = DB::scalar('select count(*) from clientes_estampas where customer_id = ? and id = ?', [$alunoID, $estampa->id]);
            $htmlMessage = "Total de estampas -> $totalEstampas";*/
            $cart = session('cart', []);
            $qtd = ($cart[$estampa->id]['qtd'] ?? 0) + 1;
            $cart[$estampa->id] = [
                'id' => $estampa->id,
                'qtd' => $qtd,
                'name' => $estampa->name,
                'image' => $estampa->image_url,
            ];
            $request->session()->put('cart', $cart);
            $alertType = 'success';
            //$url = route('estampas.show', ['estampa' => $estampa]);
            //$htmlMessage = "Tshirt <a href='$url'>#{$estampa->id}</a><strong>\"{$estampa->name}\"</strong> was added to the cart!";
        }
        
        return back()
            //->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function updateCart(Request $request, Estampa $estampa)
    {
        $cart = $request->session()->get('cart', []);
        $qtd = $cart[$estampa->id]['qtd'] ?? 0;
        $qtd += $request->quantidade;
        if ($request->quantidade < 0){
            $msg = 'Removed  ' . -$request->quantidade . ' t-shirts "' . $estampa->name . '"';
        } else if ($request->quantidade > 0){
            $msg = 'Added ' . $request->quantidade . ' t-shirts "' . $estampa->name . '"';
        }

        if($qtd <= 0)
        {
            unset($cart[$estampa->id]);
            $msg = 'Removed all t-shirts "' . $estampa->name . '"';
        } else {
            $cart[$estampa->id] = [
                'id' => $estampa->id,
                'qtd' => $qtd,
                'name' => $estampa->name,
                'image' => $estampa->image_url,
            ];
        }
        $request->session()->put('cart', $cart);
        return back()
            ->with('alert-msg', $msg)
            ->with('alert-type', 'success');
    }

    public function destroyCartTshirt(Request $request, Estampa $estampa)
    {
        $cart = $request->session()->get('cart', []);
        if (array_key_exists($estampa->id, $cart)){
            unset($cart[$estampa->id]);
            $request->session()->put('cart', $cart);
            return back()
                ->with('alert-msg', 'Removed all t-shirts related to "'. $estampa->name . '"')
                ->with('alert-type', 'success');
        }
        return back()
            ->with('alert-msg', 'T-shirt "' . $estampa->name . '" had no quantity')
            ->with('alert-type', 'warning');
    }

    /*public function index(Request $request)
    {
        return view('carrinho.index')
            ->with('pageTitle', 'Carrinho de compras')
            ->with('carrinho', session('carrinho') ?? []);
    }




    public function store(Request $request)
    {
        $carrinho = $request->session()->get('carrinho', []);
        $idEstampa = $request->input('idEstampa');
        $imagem_url = $request->input('imagem_url');
        $cor_codigo = $request->input('cor_codigo');
        $tamanho = $request->input('tamanho');
        $quantidade = $request->input('quantidade');

        if (($request->session()->get('quantidade_desconto')) < $quantidade) {
            $preco_un_catalogo = $request->session()->get('preco_un_catalogo_desconto');
            $subtotal = $preco_un_catalogo * $quantidade;
        }

        if (($request->session()->get('quantidade_desconto')) >= $quantidade) {
            $preco_un_catalogo = $request->session()->get('preco_un_catalogo');
            $subtotal = $preco_un_catalogo * $quantidade;
        }

        // $qtd = ($carrinho[$idEstampa]['qtd'] ?? 0) + 1;

        $tamanhoCarrinho = $request->session()->get('tamanhoCarrinho', 0) + 1;

        $carrinho[$tamanhoCarrinho] = [
            'idEstampa' => $idEstampa,
            'imagem_url' => $imagem_url,
            'cor_codigo' => $cor_codigo,
            'tamanho' => $tamanho,
            'quantidade' => $quantidade,
            'preco_un_catalogo' => $preco_un_catalogo,
            'subtotal' => $subtotal
        ];


        $tamanhoCarrinho = count($carrinho);
        $request->session()->put('tamanhoCarrinho', $tamanhoCarrinho);

        $request->session()->put('carrinho', $carrinho);
        //return dd($qtd);
        return back()
            ->with('alert-msg', 'Foi adicionado ao carrinho o idEstampa "' . $idEstampa . '" ao carrinho! Quantidade de inscrições = ' .  $tamanhoCarrinho)
            ->with('alert-type', 'success');
    }

    public function destroy(Request $request)
    {
        $request->session()->forget('carrinho');
        $request->session()->put('tamanhoCarrinho', 0);
        return back()
            ->with('alert-msg', 'Carrinho foi limpo!')
            ->with('alert-type', 'danger');
    }

    public function store_cart_into_sale(Request $request)
    {

        $total = 0;

        $carrinho = json_decode($request->carrinho);

        foreach ($carrinho as $asd) {
            $total = $total + $asd->subtotal;
        }



        $data = date("Y-m-d");
        $cliente_id = auth::user()->id;

        $infoCliente = Cliente::select('nif', 'endereco', 'tipo_pagamento', 'ref_pagamento')->where('id', $cliente_id)->get();


        $encomendaCriada = Encomenda::create([
            'estado' => 'pendente',
            'cliente_id' => $cliente_id,
            'data' => $data,
            'preco_total' => $total,
            'notas' => '',
            'nif' => $infoCliente[0]->nif,
            'endereco' => $infoCliente[0]->endereco,
            'tipo_pagamento' => $infoCliente[0]->tipo_pagamento,
            'ref_pagamento' => $infoCliente[0]->ref_pagamento,
            'recibo_url' => ''
        ]);




        foreach ($carrinho as $carrinhoLinha) {


            Tshirt::create([
                'encomenda_id' => $encomendaCriada->id,
                'estampa_id' => $carrinhoLinha->idEstampa,
                'cor_codigo' => $carrinhoLinha->cor_codigo,
                'tamanho' => $carrinhoLinha->tamanho,
                'quantidade' => $carrinhoLinha->quantidade,
                'preco_un' => $carrinhoLinha->preco_un_catalogo,
                'subtotal' => $carrinhoLinha->subtotal
            ]);
        }


        // $encomenda = Encomenda::all()->where('id',$encomendaCriada->id);



        $tshirtsfilter = Tshirt::all()->where('encomenda_id', $encomendaCriada['id']);

        $cliente = Cliente::all()->where('id',$encomendaCriada['cliente_id']);

        $user= User::select('name','email')->where('id',$encomendaCriada['cliente_id'])->get();

        $cliente = $cliente->toArray();

        $user = $user->toArray();

        $encomendaCriada = $encomendaCriada->toArray();

        $tshirtsfilter=$tshirtsfilter->toArray();


        $merged = array('encomenda' => $encomendaCriada,
                        'tshirtsfilter' => $tshirtsfilter,
                        'cliente' => array_slice($cliente,0)[0],
                        'user' => $user[0]);


                        $arrayCompact = compact('merged');

        $pdf = PDF::loadView('pdf.index',$arrayCompact);

        Mail::send('emailbody', $arrayCompact, function($message)use($pdf) {
            $message->to(Auth::user()->email, Auth::user()->email)
                    ->subject("Recibo em Estado Pendente")
                    ->attachData($pdf->output(), "recibo.pdf");
        });

        $request->session()->forget('carrinho');
        $request->session()->put('tamanhoCarrinho', 0);
        return redirect('/')
            ->with('alert-msg', 'Encomenda foi passada para o estado pendente !')
            ->with('alert-type', 'success');
    }*/
}
