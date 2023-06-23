@extends('template.layout')

@section('header-title', "Alterar Estampa")

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('catalogo.index') }}">Catalog</a></li>
        <li class="breadcrumb-item"><strong>{{ $estampa->name }}</strong></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('main')
    <form method="POST" action="{{ route('catalogo.update', ['catalogo' => $estampa]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="id" value="{{ $estampa->id }}">

        <div class="form-group">
            <img src="{{ $estampa->image_url ? asset('storage/tshirt_images/' . $estampa->image_url) : asset('img/default_img.png') }}" alt="Foto do estampas" class="img-profile" style="max-width:15%">
        </div>

        <div class="form-group">
            <label for="inputNome">Nome</label>
            <input type="text" class="form-control" name="name" id="inputNome" value="{{ old('name', $estampa->name) }}">
            @error('name')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputNome">Category</label>
            <input type="text" class="form-control" name="category" id="inputNome" value="{{ old('category', $estampa->categoria->name) }}">
            @error('category')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputDescricao">Description</label>
            <textarea class="form-control" name="description" id="inputDescricao" rows="5">{{ old('description', $estampa->description) }}</textarea>
            @error('description')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputFoto">Upload da foto</label>
            <input type="file" class="form-control" name="image_url" id="inputFoto">
            @error('image_url')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-success" >Save</button>
            <a href="{{ route('catalogo.edit', ['catalogo' => $estampa ?? '']) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
