@extends('template.layout')

@section('titulo', 'Carrinho')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Private Space</li>
        <li class="breadcrumb-item active">Cart</li>
    </ol>
@endsection

@section('main')
    <div>
        <h3>Tshirts in Cart</h3>
    </div>
    @if ($cart)
        @include('disciplinas.shared.table', [
            'disciplinas' => $cart,
            'showCurso' => true,
            'showDetail' => true,
            'showEdit' => false,
            'showDelete' => false,
            'showRemoveCart' => true,
        ])
        <div class="my-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" name="ok" form="formStore">Add Cart</button>
            <button type="submit" class="btn btn-danger ms-3" name="clear" form="formClear">Clear Cart</button>
        </div>
        <form id="formStore" method="POST" action="{{ route('cart.store') }}" class="d-none">
            @csrf
        </form>
        <form id="formClear" method="POST" action="{{ route('cart.destroy') }}" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection
