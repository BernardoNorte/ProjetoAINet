@extends('template.layout')

@section('titulo', 'Encomendas')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">My Orders</li>
    </ol>
@endsection

@section('main')
    @if ($encomendas)
        @include('encomendas.shared.table', [
            'encomendas' => $encomendas
        ])
    @endif
@endsection