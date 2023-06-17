<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0,
                   maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User</title>
</head>

<body>
    @extends('template.layout')

    @section('titulo', "Criar User")

    @section('subtitulo')
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
            <li class="breadcrumb-item active">Create User</li>
        </ol>
    @endsection


    @section('main')
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        @include('users.shared.fields')
        <div class="my-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" name="ok">Save new User</button>
            <a href="{{ route('users.create') }}" class="btn btn-secondary ms-3">Cancel</a>
        </div>
    </form>
    @endsection
</body>

</html>