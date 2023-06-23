@extends('template.layout')

@section('titulo', 'Encomendas')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Orders</li>
        <li class="breadcrumb-item active">List of Orders</li>
    </ol>
@endsection

@section('main')
    <form method="GET" action="{{ route('encomendas.index') }}">
        <div class="d-flex justify-content-between">
            <div class="flex-grow-1 pe-2">
                <div class="d-flex justify-content-between">
                    <div class="mb-3 me-2 flex-grow-1 form-floating">
                        <input type="number" class="form-control" name="id" id="inputID" value="{{ old('id', $filterByID) }}">
                        <label for="inputID" class="form-label">Filter by Client ID</label>
                    </div>
                </div>
            </div>
            <div class="flex-shrink-1 d-flex flex-column justify-content-between">
                <button type="submit" class="btn btn-primary mb-3 px-4 flex-grow-1" name="filtrar">Filter</button>
                <a href="{{ route('encomendas.index') }}" class="btn btn-secondary mb-3 py-3 px-4 flex-shrink-1">Clear</a>
            </div>
        </div>
    </form>
    @include('encomendas.shared.table', [
            'encomendas' => $encomendas
        ])
    <div>
        {{ $encomendas->links() }}
    </div>
@endsection


