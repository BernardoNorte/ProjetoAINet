@extends('template.layout')
@section('title','Catalogo')

@section('main')

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/catalogo.css') }}" rel="stylesheet">
</head>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">All Products</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                        <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex">
                <button class="btn btn-outline-dark" type="submit">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Header -->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shop in style</h1>
            <p class="lead fw-normal text-white-50 mb-0">With this shop homepage template</p>
        </div>
    </div>
</header>

<!-- Section -->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

@foreach ($catalogo as $item)

<div class="col mb-5">
    <div class="card h-100">
        <!-- Product image-->
        <img class="card-img-top" src="{{ $item->imagem_url ? asset('storage/estampas/' . $item->imagem_url) : asset('img/default_img.png') }}" alt="..." style="max-height=250px;"/>
        <!-- Product details-->
        <div class="card-body p-4">
            {{-- <div class="text-center">
                <!-- Product name-->
                <h5 class="fw-bolder">{{$item->nome}}</h5>
                <!-- Product price-->
                $40.00 - $80.00
            </div> --}}
        </div>
        <!-- Product actions-->
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">

            <h5 class="fw-bolder text-center">{{$item->nome}}</h5>
            <h6 class="text-center">{{session('preco_un_catalogo') . " €"}}</h6>
            @cannot('GateAdministrador')
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#" data-toggle="modal" data-target="{{'#modal'.$item->id}}">Comprar</a></div>
            @endcannot

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="{{'modal'.$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
      <div class="modal-content">
          {{-- <form action="{{route('carrinho.store')}}" method="post"> 
            @csrf --}}

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{$item->nome}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <!-- parte do select da cor-->
            <div class="form-group">

                <input type="hidden" name="idEstampa" id="inputId" value="{{$item->id}}">
                <input type="hidden" name="imagem_url" id="inputImagem_url" value="{{$item->imagem_url}}">
                <label for="exampleFormControlSelect1">Cor</label>
            <select class="form-control" id="exampleFormControlSelect1" name="cor_codigo" required>
        @foreach ($cores as $cor)
            <option value="{{$cor->codigo}}">{{$cor->nome}}</option>
        @endforeach
    </select>
</div>

    <div class="form-group">
        <label for="exampleFormControlSelect2">Tamanho</label>
        <select multiple class="form-control" id="exampleFormControlSelect2" name="tamanho" required>
        <option selected>S</option>
        <option>M</option>
        <option>L</option>
        <option>XS</option>
        <option>XL</option>
      </select>
    </div>

    <div class="form-group">
        <label for="exampleFormControlSelect2">Quantidade</label>
        <input class="form-control" type="number" id="inputQuantidade" name="quantidade" min="1" max="99" value="1" required>

    </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success" href="#">Adicionar</button>
        </div>
    </form>
      </div>
    </div>
  </div>


@endforeach
</div>
</div>
</section>
{{ $catalogo->withQueryString()->links() }}
@endsection
