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
    public function show(Request $request): View
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
            $cart = session('cart', []);
            $size = $request->input('size');
            $quantity = $request->input('quantity');
            $color = $request->input('cor_codigo');
            $price_per = $request->session()->get('unit_price_catalog');
            $total_price = $quantity * $price_per;
            $cartID = $estampa->id . '-' . $size . '-' . $color;
            if(array_key_exists($cartID, $cart))
            {
                $cart[$cartID]['quantity'] += $quantity;
                $cart[$cartID]['total'] += $total_price;
            }else {
                $cart[$cartID] = [
                    'id' => $estampa->id,
                    'cartID' => $cartID,
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

    public function destroyCartTshirt(Request $request, Estampa $estampa, $size, $color)
    {
        $cart = $request->session()->get('cart', []);

        foreach ($cart as $cartID => $cartItem) {
            if ($cartItem['id'] === $estampa->id && $cartItem['size'] === $size && $cartItem['color'] === $color) {
                unset($cart[$cartID]);
            }
        }

        $request->session()->put('cart', $cart);

        return back()
            ->with('alert-msg', 'Removed the t-shirt from the cart')
            ->with('alert-type', 'success');
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
                $htmlMessage = "The user is not a client, therefore he cannot do the operation!";
            } 
            else{
                $cart = session('cart', []);
                $totalPrice = 0;
                $total = count($cart);
                if ($total < 1) {
                    $alertType = 'warning';
                    $htmlMessage = "No T-shirts in the cart";
                } 
                else {
                    $cliente = $request->user()->cliente;
                    
                    foreach ($cart as $cartItem){
                        $totalPrice += $cartItem['total']; 
                    }

                    $order = DB::transaction(function () use ($cliente, $cart, $totalPrice){
                        
                        $newOrder = new Encomenda();
                        
                        $newOrder->customer_id = $cliente->id;
                        $newOrder->date = date("Y-m-d");
                        $newOrder->status = 'pending'; 
                        $newOrder->total_price = $totalPrice;
                        $newOrder->nif = $cliente->nif;
                        $newOrder->address = $cliente->address;
                        $newOrder->payment_type = $cliente->default_payment_type;
                        $newOrder->payment_ref = $cliente->default_payment_ref;
                        $newOrder->save();

                        foreach ($cart as $tshirt){
                            $newTshirt = new Tshirt();
                            
                            $newTshirt->order_id = $newOrder->id;
                            $newTshirt->tshirt_image_id = $tshirt["id"];
                            $newTshirt->qty = $tshirt["quantity"];
                            $newTshirt->size = $tshirt["size"];
                            $newTshirt->unit_price = $tshirt['price_per'];
                            $newTshirt->sub_total = $tshirt['total'];
                            $newTshirt->color_code = $tshirt['color'];  

                            $newTshirt->save();
                        }
                    });
                    
                    if ($total == 1) {
                        $htmlMessage = "Operation successful #{$cliente->id} <strong>\"{$request->user()->name}\"</strong>";
                    } else {
                        $htmlMessage = "Operation successful $total by client #{$cliente->id} <strong>\"{$request->user()->name}\"</strong>";
                    }
                    $request->session()->forget('cart');
                    return redirect()->route('catalogo.index')
                        ->with('alert-msg', $htmlMessage)
                        ->with('alert-type', 'success');
                }
            }
            
        } catch (\Exception $error) {
            $htmlMessage = "It was not possible, to confirm the operation!";
            $alertType = 'danger';
        }
        return redirect('login')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }
    /*

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