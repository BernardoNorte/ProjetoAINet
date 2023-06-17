@extends('template.layout')
@section('title','TShirts')

@section('main')

    <table class="table">
        <thead>
            <tr>
                <th>ID da encomenda</th>
                <th>Preview</th>
                <th>Estampa</th>
                <th>Tamanho</th>
                <th>Quantidade</th>
                <th>Preço p. Unidade</th>
                <th>SubTotal</th>
             
            </tr>
        </thead>
        <tbody>
            @foreach ($tshirts as $tshirt)
                {{--@dd($tshirt, $tshirt->estampa->imagem_url)--}}
                <tr>
                    <td>{{$tshirt->encomenda_id}}</td>
                    <td>
                        <img src="{{$tshirt ? asset('storage/tshirt_base/' . $tshirt->cor_codigo. ".jpg") : asset('img/default_img.png') }}" alt="Foto do cliente"  class="img-profile" style="width:64px;height:64px">
                    </td>
                    <td>
                        <img src="{{$tshirt ? asset('storage/estampas/' . $tshirt->estampa->imagem_url) : asset('img/default_img.png') }}" alt="Foto da Estampa"  style="width:80px;height:80px">
                    </td>
                    <td>{{$tshirt->tamanho}}</td>
                    <td>{{$tshirt->quantidade}}</td>
                    <td>{{$tshirt->preco_un}}</td>
                    <td>{{$tshirt->subtotal}}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- {{ $tshirts->withQueryString()->links() }} --}}
@endsection

