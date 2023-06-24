@extends('template.layout')
@section('title', $item->name)

@section('subtitulo')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('catalogo.index') }}">Catalogo</a></li>
    <li class="breadcrumb-item"><strong>{{ $item->name }}</strong></li>
</ol>
@endsection

@section('main')

<head>
    <link href="{{ asset('css/catalogo.css') }}" rel="stylesheet">
</head>
<form method="POST" action="{{ route('cart.add', ['estampa' => $item])}}">
@csrf
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="dropdown" style="float:right;">
                    <div class="mb-3 form-floating">
                        <select class="form-control" name="cor_codigo" id="inputColor" required>
                            @foreach($cores as $cor)
                                <option value="{{$cor->code}}" selected>{{ $cor->name }}</option>
                            @endforeach
                        </select>
                        <label for="inputColor" class="form-label">Color</label>
                    </div>
                </div>
            </div>
                <h1 class="text-center">{{ $item->name }}</h1>
                <div class="card-body p-4 d-flex align-items-center justify-content-center">
                    <img src="{{ $item->image_url ? asset('storage/tshirt_images/' . $item->image_url) : asset('img/default_img.png') }}" alt="..." width="360px" height="420px"/>
                </div>

                <h2 style="margin-left=5px;">Price: {{session('unit_price_catalog') . " €"}}</h2>
                @if($item->categoria)
                    <p style="margin-left=5px;">Category: {{ $item->categoria->name}}</p>
                @endif
                <p style="margin-left=5px;">Description: {{ $item->description }}</p>

                <!-- Adicionar ao Carrinho -->
                <input type="hidden" name="idEstampa" value="{{ $item->id }}">
                <input type="hidden" name="image_url" value="{{ $item->image_url }}">
            @if ((Auth::user()->user_type ?? '') != 'A')
            <div class="form-group">
                <div class="form-group">
                <div class="mb-3 form-floating">
                    <select class="form-control" name="size" id="inputSize" required>
                        <option value="S" selected>S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                    <label for="inputSize" class="form-label">Size</label>
                </div>
            </div>
            <div class="form-group">
                <div class="mb-3 form-floating">
                    <input class="form-control" type="number" id="inputQuantity" name="quantity" min="1" max="99" value="1" required>
                    <label for="exampleFormControlSelect2">Quantity</label>
                </div>
            </div>
            <div class="text-center">
                    <form method="POST" action="{{ route('cart.add', ['estampa' => $item]) }}">
                        @csrf 
                        <button type="submit" name="addToCart" class="btn btn-outline-dark mt-auto">Add to Cart</button>
                    </form>
            </div>
            @endif
        </div>
    </div>
@endsection