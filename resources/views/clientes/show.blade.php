@extends('template.layout')

@section('titulo', 'Client')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Client</a></li>
        <li class="breadcrumb-item"><strong>{{ $cliente->user->name }}</strong></li>
    </ol>
@endsection

@section('main')
    <div>
        @include('clientes.shared.fields', ['readonlyData' => true])
    </div>
    <div class="my-4 d-flex justify-content-end">
        <a href="{{ route('clientes.edit', ['cliente' => $cliente]) }}" class="btn btn-secondary ms-3">Edit Client</a>
    </div>
@endsection
