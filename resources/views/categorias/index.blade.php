@extends('layout')
@section('title','Categorias')
@section('content')

<table class="table">
    <thead>
        <tr>
            <th>idCategoria</th>
            <th>nome</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categorias as $categoria)
            <tr>
                <td>{{$categoria->id}}</td>
                <td>{{$categoria->nome}}</td>
                <td>
                    <a href="{{route('categorias.edit', ['categoria' => $categoria]) }}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Editar</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
