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

    @section('header-title', "Alterar Cliente")

    @section('subtitulo')
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><strong>{{ $cliente->user->name }}</strong></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    @endsection

    @section('main')
    <form id="form_cliente" method="POST" action="{{ route('clientes.update', ['cliente' => $cliente]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start">
            <div class="flex-grow-1 pe-2">
                @include('users.shared.fields', ['user' => $cliente->user, 'showBlocked' => false, 'showUserType' => false, 'readonlyData' => false])
                @include('clientes.shared.fields', ['cliente' => $cliente, 'showID' => false, 'readonlyData' => false])
                <div class="my-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" name="ok" form="form_cliente">Save</button>
                    <a href="{{ route('clientes.show', ['cliente' => $cliente]) }}" class="btn btn-secondary ms-3">Cancel</a>
                </div>
            </div>
                <div class="ps-2 mt-5 mt-md-1 d-flex mx-auto flex-column align-items-center justify-content-between"
                    style="min-width:260px; max-width:260px;">
                    @include('users.shared.fields_foto', [
                        'user' => $cliente->user,
                        'allowUpload' => true,
                        'allowDelete' => true,
                    ])
            </div>
        </div>
    </form>
    @include('shared.confirmationDialog', [
        'title' => 'Apagar fotografia',
        'msgLine1' => 'As alterações efetuadas aos dados do cliente vão ser perdidas!',
        'msgLine2' => 'Clique no botão "Apagar" para confirmar a operação.',
        'confirmationButton' => 'Apagar fotografia',
        'formAction' => route('clientes.foto.destroy', ['cliente' => $cliente->user->cliente]),
        'formMethod' => 'DELETE',
    ])
    @endsection
</body>

</html>
