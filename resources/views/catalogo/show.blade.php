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
                <div class="card-body p-4 d-flex align-items-center justify-content-center">
                    <img src="{{ $item->image_url ? asset('storage/tshirt_images/' . $item->image_url) : asset('img/default_img.png') }}" alt="..." width="360px" height="420px"/>
                </div>
                <p>{{ $item->description }}</p>
                <p>Price: {{session('unit_price_catalog') . " €"}}</p>
                <!-- Adicionar ao Carrinho -->
                <form  method="POST">
                    @csrf
                    <input type="hidden" name="idEstampa" value="{{ $item->id }}">
                    <input type="hidden" name="image_url" value="{{ $item->image_url }}">
                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-dark mt-auto">Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection