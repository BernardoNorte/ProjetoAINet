@extends('template.layout')

@section('titulo', 'Clientes')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Clients</li>
        <li class="breadcrumb-item active">List of Clients</li>
    </ol>
@endsection

@section('main')
    <p>
        <a class="btn btn-success" href="{{ route('clientes.create') }}"><i class="fas fa-plus"></i> &nbsp;Create new Client</a>
    </p>
    <form method="GET" action="{{ route('clientes.index') }}">
        <div class="d-flex justify-content-between">
            <div class="flex-grow-1 pe-2">
                <div class="d-flex justify-content-between">
                    <div class="mb-3 me-2 flex-grow-1 form-floating">
                        <input type="text" class="form-control" name="nome" id="inputNome"
                            value="{{ old('nome', $filterByNome) }}">
                        <label for="inputNome" class="form-label">Name</label>
                    </div>
                </div>
            </div>
            <div class="flex-shrink-1 d-flex flex-column justify-content-between">
                <button type="submit" class="btn btn-primary mb-3 px-4 flex-grow-1" name="filtrar">Filtrar</button>
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary mb-3 py-3 px-4 flex-shrink-1">Limpar</a>
            </div>
        </div>
    </form>
    @include('clientes.shared.table', [
        'clientes' => $clientes,
        'showContatos' => true,
        'showDetail' => true,
        'showPhoto' => true,
    ])
    <div>
        <div>
            {{ $clientes->links() }}
        </div>
@endsection