@extends('template.layout')
@section('title','Estampas')

@section('content')

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>Nome</th>
            <th>descrição</th>
            @if ($showAddCart ?? false)
                <th class="button-icon-col"></th>
            @endif
            @if ($showRemoveCart ?? false)
                <th class="button-icon-col"></th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($estampas as $estampa)
        <tr>
            <td>
                <img src="{{$estampa->imagem_url ? asset('storage/estampas/' . $estampa->imagem_url) : asset('img/default_img.png') }}" alt="Foto da Estampa"  style="width:80px;height:80px">
            </td>
            <td>
                {{$estampa->nome}}
            </td>

            <td>
                {{$estampa->descricao}}
            </td>
            <td>
                <a href="{{route('estampas.edit', ['estampa' => $estampa]) }}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Editar</a>
            </td>
            @if ($showAddCart ?? false)
                <td class="button-icon-col">
                    <form method="POST" action="{{ route('cart.add', ['estampa' => $estampa]) }}">
                        @csrf 
                        <button type="submit" name="addToCart" class="btn btn-success">
                            <i class="fas fa-plus"></i></button>
                    </form>
                </td>
            @endif
            @if ($showRemoveCart ?? false)
                <td class="button-icon-col">
                    <form method="POST" action="{{ route('cart.remove', ['estampa' => $estampa]) }}">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" name="removeFromCart" class="btn btn-danger">
                            <i class="fas fa-remove"></i></button>
                    </form>
                </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
    {{ $estampas->withQueryString()->links() }}
@endsection
