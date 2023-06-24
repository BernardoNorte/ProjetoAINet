@extends('template.layout')
@section('title','Catalogo')

@section('main')

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title')</title>
    <link href="{{ asset('css/catalogo.css') }}" rel="stylesheet">
    <script src="{{ asset('js/scripts.js') }}" rel="stylesheet"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<form method="GET" action="{{ route('catalogo.index') }}">
    <div class="d-flex justify-content-between">
        <div class="flex-grow-1 pe-2">
            <div class="d-flex justify-content-between">
                <div class="flex-grow-1 mb-3 form-floating">
                    <select class="form-select" name="categoria" id="inputcategoria">
                        <option {{ old('categoria', $filterByCategoria) === '' ? 'selected' : '' }} 
                            value="">All categories</option>
                        @foreach ($categorias as $categoria)
                        <option {{ old('categoria', $filterByCategoria) == $categoria->id ? 'selected' : '' }} 
                            value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                        @endforeach
                    </select>
                    <label for="inputCategoria" class="form-label">Category</label>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="flex-grow-1 mb-3 form-floating">
                    <select class="form-select" name="description" id="inputdescription">
                        <option {{ old('description', $filterByDescricao) === '' ? 'selected' : '' }} 
                            value="">All descriptions</option>
                        @foreach ($estampas as $estampa)
                        <option {{ old('description', $filterByDescricao) == $estampa->description ? 'selected' : '' }} 
                            value="{{ $estampa->description }}">{{ $estampa->description }}</option>
                        @endforeach
                    </select>
                    <label for="inputDescricao" class="form-label">Description</label>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="mb-3 me-2 flex-grow-1 form-floating">
                    <input type="text" class="form-control" name="name" id="inputName"
                        value="{{ old('name', $filterByNome) }}">
                    <label for="inputName" class="form-label">Name</label>
                </div>
            </div>
        </div>
        <div class="flex-shrink-1 d-flex flex-column justify-content-between">
            <button type="submit" class="btn btn-primary mb-3 px-4 flex-grow-1" name="filtrar">Filter</button>
            <a href="{{ route('catalogo.index') }}" class="btn btn-secondary mb-3 py-3 px-4 flex-shrink-1">Clean</a>
        </div>
    </div>
</form>

@php
$firstItem = $catalogo->first();
@endphp

@if ($firstItem)
<a class="btn btn-outline-success mt-auto" href="{{ route('catalogo.edit', ['catalogo' => $firstItem]) }}">Create new print</a>
@endif

<!-- Section -->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

@foreach ($catalogo as $item)
        
    <div class="col mb-5">
        <div class="card h-100">
            <!-- Product image-->
            <img class="card-img-top" src="{{ $item->image_url ? asset('storage/tshirt_images/' . $item->image_url) : asset('img/default_img.png') }}" alt="..." style="max-height=250px;"/>
            <!-- Product details-->
            <div class="card-body p-4">
                {{-- <div class="text-center">
                    <!-- Product name-->
                    <h5 class="fw-bolder">{{$item->name}}</h5>
                </div> --}}
            </div>
            <!-- Product actions-->
            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <h5 class="fw-bolder text-center">{{$item->name}}</h5>
                @if($item->categoria)
                <h5 class="fw-bolder text-center">Category: {{$item->categoria->name}}</h5>
                @endif
                <h6 class="text-center">{{session('unit_price_catalog') . " €"}}</h6>
                <div class="popup" onclick="myFunction('popup{{$item->id}}')">
                    <h6 class="text-center">Description</h6>
                    <span class="popuptext" id="popup{{$item->id}}">
                        <p>{{$item->description}}</p>
                    </span>
                </div>
                @if ((Auth::user()->user_type ?? '') != 'A')
                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{ route('catalogo.show', ['id' => $item->id]) }}">Buy</a></div>
                @endif
                @if ((Auth::user()->user_type ?? '') == 'A')
                <div class="text-center">
                    <a class="btn btn-outline-dark mt-auto" href="{{ route('catalogo.show', ['id' => $item->id]) }}">View</a>
                    <a class="btn btn-outline-dark mt-auto" href="{{ route('catalogo.edit', ['catalogo' => $item]) }}">Edit</a>
                    {{-- <form action="{{ route('catalogo.destroy', ['id' => 323]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <!-- Resto dos campos do formulário -->
                        <button type="submit">Delete</button>
                    </form> --}}
                </div>
                @endif
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
                    <input type="hidden" name="image_url" id="inputimage_url" value="{{$item->image_url}}">
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
{{ $catalogo->withQueryString()->links() }}
</div>
</section>

@endsection
