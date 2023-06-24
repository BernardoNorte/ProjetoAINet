@extends('template.layout')

@section('titulo', 'Encomendas')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Orders</li>
        <li class="breadcrumb-item active">List of Orders</li>
    </ol>
@endsection

@section('main')
    @if ((Auth::user()->user_type ?? '') == 'A')
        <form method="GET" action="{{ route('encomendas.index') }}">
            <div class="d-flex justify-content-between">
                <div class="flex-grow-1 pe-2">
                    <div class="d-flex justify-content-between">
                        <div class="mb-3 me-2 flex-grow-1 form-floating">
                            <select id="inputStatus" class="form-select @error('inputStatus') is-invalid @enderror" name="inputStatus" required>
                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }} selected>Pending</option>
                                <option value="paid" {{ old('status', 'paid') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="closed" {{ old('status', 'closed') == 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="canceled" {{ old('status', 'canceled') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                            <label for="inputStatus" class="form-label">Filter by Status</label>
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1 pe-2">
                    <div class="d-flex justify-content-between">
                        <div class="mb-3 me-2 flex-grow-1 form-floating">
                            <input type="text" class="form-control" name="nome" id="inputNome"
                                value="{{ old('name', $filterNome) }}">
                            <label for="inputNome" class="form-label">Filter By Name</label>
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1 pe-2">
                    <div class="d-flex justify-content-between">
                        <div class="mb-3 me-2 flex-grow-1 form-floating">
                            <input type="date" class="form-control" name="date" id="inputDate"
                                value="{{ old('date', $filterDate) }}">
                            <label for="inputDate" class="form-label">Filter By Date</label>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-1 d-flex flex-column justify-content-between">
                    <button type="submit" class="btn btn-primary mb-3 px-4 flex-grow-1" name="filtrar">Filter</button>
                    <a href="{{ route('encomendas.index') }}" class="btn btn-secondary mb-3 py-3 px-4 flex-shrink-1">Clear</a>
                </div>
            </div>
        </form>
    @endif
    @include('encomendas.shared.table', [
            'encomendas' => $encomendas
        ])
    <div>
        {{ $encomendas->withQueryString()->links() }}
    </div>
@endsection


