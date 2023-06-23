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
            $size = $request->input('size');
            $quantity = $request->input('quantity');
            $color = $request->input('cor_codigo');
            $price_per = $request->session()->get('unit_price_catalog');
            $total_price = $quantity * $price_per;
            $cartID = $estampa->id;
            if(array_key_exists($cartID, $cart))
            {
                $cart[$cartID]['quantity'] += $quantity;
                $cart[$cartID]['total'] += $total_price;
            }else {
                $cart[$cartID] = [
                    'id' => $estampa->id,
                    'size' => $size,
                    'quantity' => $quantity,
                    'color' => $color,
                    'name' => $estampa->name,
                    'image' => $estampa->image_url,
                    'price_per' => $price_per,
                    'total' => $total_price,
                ];
            }
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
        $cartID = $estampa->id;
        $qtd = $cart[$cartID]['quantity'] ?? 0;
        $qtd += $request->input('quantity');
        if ($request->input('quantity') < 0){
            $msg = 'Removed  ' . -$request->input('quantity') . ' t-shirts "' . $estampa->name . '"';
        } else if ($request->input('quantity') > 0){
            $msg = 'Added ' . $request->input('quantity') . ' t-shirts "' . $estampa->name . '"';
        }

        if($qtd <= 0)
        {
            unset($cart[$cartID]);
            $msg = 'Removed all t-shirts "' . $estampa->name . '"';
        } else {
            $cart[$cartID] = [
                'id' => $estampa->id,
                'size' => $cart[$cartID]['size'],
                'quantity' => $qtd,
                'color' => $cart[$cartID]['color'],
                'name' => $estampa->name,
                'image' => $estampa->image_url,
                'price_per' => $cart[$cartID]['price_per'],
                'total' => $cart[$cartID]['total'],
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
        $cartID = $estampa->id;
        if (array_key_exists($cartID, $cart)){
            unset($cart[$cartID]);
            $request->session()->put('cart', $cart);
            return back()
                ->with('alert-msg', 'Removed all t-shirts related to "'. $estampa->name . '"')
                ->with('alert-type', 'success');
        }
        return back()
            ->with('alert-msg', 'T-shirt "' . $estampa->name . '" had no quantity')
            ->with('alert-type', 'warning');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        $htmlMessage = "Flushed Cart!";
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }


    public function store(Request $request): RedirectResponse
    {
        try {
            $userType = $request->user()->user_type ?? 'C';
            if ($userType != 'C') {
                $alertType = 'warning';
                $htmlMessage = "O utilizador não é cliente, logo não pode confirmar a compra do carrinho";
            } 
            else{
                $cart = session('cart', []);
                $precoTotal = 0;
                $total = count($cart);
                if ($total < 1) {
                    $alertType = 'warning';
                    $htmlMessage = "Não é possível confirmar a compra porque não há t-shirts no carrinho";
                } 
                else {
                    $cliente = $request->user()->cliente;
                    
                    foreach ($cart as $cartItem){
                        $precoTotal += $cartItem['total']; 
                    }

                    $order = DB::transaction(function () use ($cliente, $cart, $precoTotal){
                        
                        $newOrder = new Encomenda();
                        
                        $newOrder->customer_id = $cliente->id;
                        $newOrder->date = date("Y-m-d");
                        $newOrder->status = 'pending'; 
                        $newOrder->total_price = $precoTotal;
                        $newOrder->nif = $cliente->nif;
                        $newOrder->address = $cliente->address;
                        $newOrder->payment_type = $cliente->default_payment_type;
                        $newOrder->payment_ref = $cliente->default_payment_ref ?? (Auth::user()->mail ?? '');
                        
                        $newOrder->save();
                        //debug($newOrder);

                        foreach ($cart as $tshirt){
                            $newOrderItem = new Tshirt();
                            
                            $newOrderItem->order_id = $newOrder->id;
                            $newOrderItem->tshirt_image_id = $tshirt["id"];
                            $newOrderItem->qty = $tshirt["quantity"];
                            $newOrderItem->size = $tshirt["size"];

                            
                            $newOrderItem->unit_price = $tshirt['price_per'];
                            $newOrderItem->sub_total = $tshirt['total'];
                            $newOrderItem->color_code = $tshirt['color'];
                            //debug($newOrderItem);

                            $newOrderItem->save();
                        }
                    });
                    
                    if ($total == 1) {
                        $htmlMessage = "Foi confirmada a compra de 1 item pelo cliente #{$cliente->id} <strong>\"{$request->user()->name}\"</strong>";
                    } else {
                        $htmlMessage = "Foi confirmada a compra de $total item pelo cliente #{$cliente->id} <strong>\"{$request->user()->name}\"</strong>";
                    }
                    $request->session()->forget('cart');
                    return redirect()->route('catalogo.index')
                        ->with('alert-msg', $htmlMessage)
                        ->with('alert-type', 'success');
                }
            }
            
        } catch (\Exception $error) {
            $htmlMessage = "Não foi possível confirmar a compra, porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return redirect('login')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
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
        $quantity = $request->input('quantity');

        if (($request->session()->get('quantity_desconto')) < $quantity) {
            $preco_un_catalogo = $request->session()->get('preco_un_catalogo_desconto');
            $subtotal = $preco_un_catalogo * $quantity;
        }

        if (($request->session()->get('quantity_desconto')) >= $quantity) {
            $preco_un_catalogo = $request->session()->get('preco_un_catalogo');
            $subtotal = $preco_un_catalogo * $quantity;
        }

        // $qtd = ($carrinho[$idEstampa]['qtd'] ?? 0) + 1;

        $tamanhoCarrinho = $request->session()->get('tamanhoCarrinho', 0) + 1;

        $carrinho[$tamanhoCarrinho] = [
            'idEstampa' => $idEstampa,
            'imagem_url' => $imagem_url,
            'cor_codigo' => $cor_codigo,
            'tamanho' => $tamanho,
            'quantity' => $quantity,
            'preco_un_catalogo' => $preco_un_catalogo,
            'subtotal' => $subtotal
        ];


        $tamanhoCarrinho = count($carrinho);
        $request->session()->put('tamanhoCarrinho', $tamanhoCarrinho);

        $request->session()->put('carrinho', $carrinho);
        //return dd($qtd);
        return back()
            ->with('alert-msg', 'Foi adicionado ao carrinho o idEstampa "' . $idEstampa . '" ao carrinho! quantity de inscrições = ' .  $tamanhoCarrinho)
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
                'quantity' => $carrinhoLinha->quantity,
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