@extends('template.layout')
@section('title', $item->name)

@section('main')

<head>
    <link href="{{ asset('css/catalogo.css') }}" rel="stylesheet">
</head>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="dropdown" style="float:right;">
                    <button class="dropbtn">Choose color</button>
                    <div class="dropdown-content">
                    @foreach($cores as $cor)
                        <a href="#">{{ $cor->name }}</a>
                    @endforeach
                    </div>
                </div>
            </div>
                <h1>{{ $item->name }}</h1>
                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" width="200">
                <p>{{ $item->description }}</p>
                <p>Preço: {{session('unit_price_catalog') . " €"}}</p>
                <!-- Adicionar ao Carrinho -->
                <input type="hidden" name="idEstampa" value="{{ $item->id }}">
                <input type="hidden" name="image_url" value="{{ $item->image_url }}">
                <div class="text-center">
                    <form method="POST" action="{{ route('cart.add', ['estampa' => $item]) }}">
                        @csrf 
                        <button type="submit" name="addToCart" class="btn btn-outline-dark mt-auto">Add to Cart</button>
                    </form>
                    </div>
            </div>
        </div>
    </div>
@endsection