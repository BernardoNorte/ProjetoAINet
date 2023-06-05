@extends('layout')
@section('title', 'Alterar Categoria')
@section('content')


<form method="POST" action="{{ route('categorias.update', ['categoria' => $categoria]) }}" class="form-group"
    enctype="multipart/form-data">
    @csrf

    @method('PUT')

   
        <input type="hidden" name="id" value="{{ $categoria->id }}">


        <div class="form-group">
            <label for="inputNome">Nome</label>
            <input type="text" class="form-control" name="nome" id="inputNome"
                value="{{ old('nome', $categoria->nome) }}">
            @error('nome')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
</form>
@endsection
