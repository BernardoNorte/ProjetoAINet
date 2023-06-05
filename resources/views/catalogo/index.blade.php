@extends('layout')
@section('title','Catalogo')

@section('content')

<head>

    <link href="css/catalogo.css" rel="stylesheet"/>
</head>

<form class="disc-search" action="#" method="GET">

    <div class="input-group mb-3">
        <select name="idcategoria">
            <option value="0">Todas a categorias</option>

            @foreach($categorias as $categoria)
                <option value="{{$categoria['id']}}" {{$idcategoria == $categoria['id'] ? 'selected' : ''}}>{{$categoria['nome']}}</option>
            @endforeach
        </select>

    <div class="input-group-append">
        <button type="submit" class="bt" id="btn-filter">Filtrar</button>
    </div>
</div>
</form>

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
          <form action="{{route('carrinho.store')}}" method="post">
            @csrf

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
