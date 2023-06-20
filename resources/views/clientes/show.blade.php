@extends('template.layout')

@section('titulo', 'Client')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><strong>{{ $cliente->user->name }}</strong></li>
    </ol>
@endsection

@section('main')
    <div>
        <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start">
            <div class="flex-grow-1 pe-2">
                @include('users.shared.fields', ['user' => $cliente->user, 'showBlocked' => false, 'showUserType' => false, 'readonlyData' => true])
                @include('clientes.shared.fields', ['cliente' => $cliente, 'showID' => false, 'readonlyData' => true])
                <div class="my-1 d-flex justify-content-end">
                    <form method="POST" action="{{ route('clientes.destroy', ['cliente' => $cliente]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="delete" class="btn btn-danger">
                            Delete client
                        </button>
                    </form>
                    <a href="{{ route('clientes.edit', ['cliente' => $cliente]) }}" class="btn btn-secondary ms-3">
                        Change client
                    </a>
                </div>
            </div>
            <div class="ps-2 mt-5 mt-md-1 d-flex mx-auto flex-column align-items-center justify-content-between"
                style="min-width:260px; max-width:260px;">
                @include('users.shared.fields_foto', [
                    'user' => $cliente->user,
                    'allowUpload' => false,
                    'allowDelete' => false,
                ])
            </div>
        </div>
    </div>
@endsection
