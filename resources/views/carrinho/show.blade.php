@extends('template.layout')

@section('content')


<div class="row">
<form action="{{ route('carrinho.destroy') }}" method="POST">
    @csrf
    @method("DELETE")
    <input type="submit" class="btn btn-danger" value="Apagar carrinho">
</form>

</div>
<br>
@endif



<table class="table">
    <thead>
        <tr>

            <th>Tshirt ID</th>
            <th>Photo</th>
            <th>Color</th>
            <th>Size</th>
            <th>Quantity</th>
            <th>Price per</th>
            <th>Sub Total</th>
        </tr>
    </thead>
    <tbody>



@foreach ($carrinho as $carrinhoLinha)

<tr>

    <td>{{$carrinhoLinha['idEstampa']}}</td>
    <td><img src="{{$carrinhoLinha['imagem_url'] ? asset('storage/estampas/' . $carrinhoLinha['imagem_url']) : asset('img/default_img.png') }}" alt="Foto da Estampa"  style="width:80px;height:80px"></td>
    {{-- <td>{{$carrinhoLinha['imagem_url']}}</td> --}}
    

    <td>{{$carrinhoLinha['tamanho']}}</td>
    <td>{{$carrinhoLinha['quantidade']}}</td>
    <td>{{$carrinhoLinha['preco_un_catalogo']}}</td>
    <td>{{$carrinhoLinha['subtotal']}}</td>

<td>
</td>
</tr>
@endforeach

</tbody>
</table>
@endsection

