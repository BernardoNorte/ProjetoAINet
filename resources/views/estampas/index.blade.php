@extends('layout')
@section('title','Estampas')

@section('content')

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>Nome</th>
            <th>descrição</th>
            <th></th>
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
        </tr>
        @endforeach
    </tbody>
</table>
    {{ $estampas->withQueryString()->links() }}
@endsection
