@extends('layout')

@section('title', 'Preços')

@section('content')

    <form method="POST" action="{{ route('precos.update', ['precos' => $precos]) }}" class="form-group"
        enctype="multipart/form-data">
        @csrf

        @method('PUT')
        <table class="table">

            <tbody>

                <tr>
                    <td>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> Preço no catalogo</span>
                            </div>
                            <input class="form-control" type="number" name="preco_un_catalogo" value="{{ $precos[0]->preco_un_catalogo }}">
                            <div class="input-group-append">
                                <span class="input-group-text">€</span>
                        </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> Preço proprio</span>
                            </div>
                            <input class="form-control" type="number" name="preco_un_proprio" value="{{ $precos[0]->preco_un_proprio }}">
                            <div class="input-group-append">
                                <span class="input-group-text">€</span>
                        </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> Preço no catalogo c/ desconto</span>
                            </div>
                            <input class="form-control" type="number" name="preco_un_catalogo_desconto"
                                value="{{ $precos[0]->preco_un_catalogo_desconto }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">€</span>

                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> Preço proprio c/ desconto</span>
                            </div>
                            <input class="form-control" type="number" name="preco_un_proprio_desconto"
                                value="{{ $precos[0]->preco_un_proprio_desconto }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">€</span>
                        </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> Quantidade p/ Desconto</span>
                            </div>
                            <input class="form-control" type="number" name="quantidade_desconto" value="{{ $precos[0]->quantidade_desconto }}">
                            <div class="input-group-append">
                                <span class="input-group-text">unidades</span>
                        </div>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>

        <button type="submit" class="btn btn-success" href="#">Submeter</button>
    </form>

    <form action="{{ route('precos.reset') }}" method="get">
        <button type="submit" class="btn btn-warning" href="#"> Repor Valores Originiais</button>
    </form>

@endsection
