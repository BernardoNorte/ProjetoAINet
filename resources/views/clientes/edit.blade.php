<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0,
                   maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Client</title>
</head>

<body>
    @extends('template.layout')

    @section('header-title', "Alterar $cliente->user->name")

    @section('subtitulo')
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clients</a></li>
            <li class="breadcrumb-item"><strong>{{ $cliente->user->name }}</strong></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    @endsection

    @section('main')
    <form method="POST" action="{{ route('clientes.update', ['cliente' => $cliente]) }}">
        @csrf
        @method('PUT')
        @include('clientes.shared.fields')
        <div class="my-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" name="ok">Save</button>
            <a href="{{ route('clientes.edit', ['cliente' => $cliente]) }}" class="btn btn-secondary ms-3">Cancel</a>
        </div>
    </form>
    @endsection
</body>

</html>