@extends('template.layout')

@section('titulo', 'Encomendas')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Orders</li>
        <li class="breadcrumb-item active">List of Orders</li>
    </ol>
@endsection

@section('main')
    <p>
        <a class="btn btn-success" href="{{ route('encomendas.create') }}"><i class="fas fa-plus"></i> &nbsp;Create new order</a>
    </p>
    @include('encomendas.shared.table', [
            'encomendas' => $encomendas
        ])
    <div>
        {{ $encomendas->links() }}
    </div>
@endsection


