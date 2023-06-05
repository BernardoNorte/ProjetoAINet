@extends('layout')

@section('content')

@if(session('tamanhoCarrinho') ?? 0 !=0)

<div class="row">
<form action="{{ route('carrinho.destroy') }}" method="POST">
    @csrf
    @method("DELETE")
    <input type="submit" class="btn btn-danger" value="Apagar carrinho">
</form>

<form action="{{ route('carrinho.store_cart_into_sale') }}" method="POST">
    @csrf
    <input type="hidden" name="carrinho" value="{{json_encode($carrinho)}}">
    <input type="submit" class="btn btn-success" value="Finalizar Encomenda">
</form>
</div>
<br>
@endif



<table class="table">
    <thead>
        <tr>

            <th>idEstampa</th>
            <th>imagem_url</th>
            <th>cor_codigo</th>
            <th>tamanho</th>
            <th>quantidade</th>
            <th>preco_un</th>
            <th>subtotal</th>
            <th>preview</th>
        </tr>
    </thead>
    <tbody>



@foreach ($carrinho as $carrinhoLinha)

<tr>

    <td>{{$carrinhoLinha['idEstampa']}}</td>
    <td><img src="{{$carrinhoLinha['imagem_url'] ? asset('storage/estampas/' . $carrinhoLinha['imagem_url']) : asset('img/default_img.png') }}" alt="Foto da Estampa"  style="width:80px;height:80px"></td>
    {{-- <td>{{$carrinhoLinha['imagem_url']}}</td> --}}
    <td>
        <svg style="fill:{{"#".$carrinhoLinha['cor_codigo']}}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16">
            <circle cx="8" cy="8" r="8"/>
          </svg>
    </td>
    {{-- <td><img src="{{$carrinhoLinha['cor_codigo']}}"></td> --}}

    <td>{{$carrinhoLinha['tamanho']}}</td>
    <td>{{$carrinhoLinha['quantidade']}}</td>
    <td>{{$carrinhoLinha['preco_un_catalogo']}}</td>
    <td>{{$carrinhoLinha['subtotal']}}</td>

<td>
<button class="btn btn-warning" onClick="MyWindow=window.open('preview?tshirt={{$carrinhoLinha['cor_codigo'].".jpg"}}&estampa={{$carrinhoLinha['imagem_url']}}','popup','width=500,height=550'); return false;">Preview</button>
</td>
</tr>
@endforeach

</tbody>
</table>
@endsection

