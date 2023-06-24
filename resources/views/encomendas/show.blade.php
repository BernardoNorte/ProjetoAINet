@extends('template.layout')

@section('titulo', 'Order')

@section('subtitulo')
    <ol class="breadcrumb">
        @if ((Auth::user()->user_type ?? '') != 'C')
            <li class="breadcrumb-item"><a href="{{ route('encomendas.index') }}">Order</a></li>
        @endif
        <li class="breadcrumb-item"><strong>{{ $encomenda->id }}</strong></li>
        <li class="breadcrumb-item active">Show</li>
    </ol>
@endsection

@section('main')
    <div>
    @include('encomendas.shared.fields', ['encomenda' => $encomenda, 'showorderID' => true, 'showTotalPrice' => true, 'readonlyData' => true])
    </div>
    @if ((Auth::user()->user_type ?? '') == 'E')
        <div class="my-4 d-flex justify-content-end">
            <a href="{{ route('encomendas.edit', ['encomenda' => $encomenda]) }}" class="btn btn-secondary ms-3">Edit Order</a>
        </div>
    @endif

@endsection