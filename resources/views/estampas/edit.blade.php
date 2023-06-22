@extends('template.layout')
@section('title', 'Alterar Estampa')
@section('content')


<form method="POST" action="{{ route('estampas.update', ['estampa' => $estampas]) }}" class="form-group"
    enctype="multipart/form-data">
    @csrf

    @method('PUT')
        <input type="hidden" name="id" value="{{ $estampas->id }}">

        <div class="form-group">
            <img src="{{ $estampas->imagem_url ? asset('storage/estampas/' . $estampas->imagem_url) : asset('img/default_img.png') }}"
                alt="Foto do estampas" class="img-profile" style="max-width:15%">
        </div>

        <div class="form-group">
            <label for="inputNome">Nome</label>
            <input type="text" class="form-control" name="nome" id="inputNome"
                value="{{ old('nome', $estampas->nome) }}">
            @error('nome')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputDescrição">Descrição</label>
            <textarea class="form-control" name="descricao" id="inputDescricao" rows=5>{{old('descricao', $estampas->descricao)}}</textarea>
            @error('objetivos')
                <div class="small text-danger">{{$message}}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputFoto">Upload da foto</label>
            <input type="file" class="form-control" name="imagem_url" id="inputFoto">
            @error('foto')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a href="{{ route('estampas.edit', ['estampa' => $estampas ?? '']) }}" class="btn btn-secondary">Cancel</a>
        </div>
</form>
@endsection
