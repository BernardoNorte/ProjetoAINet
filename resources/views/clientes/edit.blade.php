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
    <form id="form_cliente" novalidate class="needs-validation" method="POST"
        action="{{ route('clientes.update', ['cliente' => $cliente]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start">
            <div class="flex-grow-1 pe-2">
                @if ((Auth::user()->user_type ?? '') == 'A')
                    @include('users.shared.fields', ['user' => $cliente->user, 'showBlocked' => false, 'showUserType' => false, 'readonlyData' => false])
                @else
                    @include('users.shared.fields', ['user' => $cliente->user, 'showBlocked' => false, 'showUserType' => false, 'readonlyData' => false])
                @endif
                @if ((Auth::user()->user_type ?? '') == 'A')
                    @include('clientes.shared.fields', ['cliente' => $cliente, 'showID' => false, 'allowRemove' => true,'readonlyData' => false])
                @else 
                    @include('clientes.shared.fields', ['cliente' => $cliente, 'showID' => false, 'allowRemove' => false, 'readonlyData' => false])
                @endif
                <div class="my-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" name="ok" form="form_cliente">Save</button>
                    <a href="{{ route('clientes.show', ['cliente' => $cliente]) }}" class="btn btn-secondary ms-3">Cancel</a>
                </div>
            </div>
                <div class="ps-2 mt-5 mt-md-1 d-flex mx-auto flex-column align-items-center justify-content-between"
                    style="min-width:260px; max-width:260px;">
                    @if ((Auth::user()->user_type ?? '') == 'A')
                        @include('users.shared.fields_foto', [
                            'user' => $cliente->user,
                            'allowUpload' => false,
                            'allowDelete' => false,
                            'allowBlocked' => true,
                        ])
                    @else 
                        @include('users.shared.fields_foto', [
                            'user' => $cliente->user,
                            'allowUpload' => true,
                            'allowDelete' => true,
                        ])
                    @endif
            </div>
        </div>
    </form>
    @include('shared.confirmationDialog', [
        'title' => 'Remove Photo',
        'msgLine1' => 'All the data that was changed will be lost!',
        'msgLine2' => 'Press the button "Remove Photo" to confirm the operation',
        'confirmationButton' => 'Remove Photo', 
        'formAction' => route('clientes.foto.destroy', ['cliente' => $cliente->user->cliente]),
        'formMethod' => 'DELETE',
    ])
    @endsection
</body>

</html>
