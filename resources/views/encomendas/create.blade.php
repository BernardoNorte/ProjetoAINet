<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0,
                   maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Encomenda</title>
</head>

<body>
    @extends('template.layout')

    @section('titulo', "Criar encomenda")

    @section('subtitulo')
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('encomendas.index') }}">Orders</a></li>
            <li class="breadcrumb-item active">Create Order</li>
        </ol>
    @endsection


    @section('main')
    <form method="POST" action="{{ route('encomendas.store') }}">
        @csrf
        @include('encomendas.shared.fields')
        <div class="my-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" name="ok">Save new Order</button>
            <a href="{{ route('encomendas.create') }}" class="btn btn-secondary ms-3">Cancel</a>
        </div>
    </form>
    @endsection
</body>

</html>