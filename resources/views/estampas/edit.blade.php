@extends('template.layout')

@section('content')
    <form method="POST" action="{{ route('catalogo.update', ['estampa' => $estampa]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="id" value="{{ $estampa->id }}">

        <div class="form-group">
            <img src="{{ $estampa->image_url ? asset('storage/estampas/' . $estampa->image_url) : asset('img/default_img.png') }}" alt="Foto do estampas" class="img-profile" style="max-width:15%">
        </div>

        <div class="form-group">
            <label for="inputNome">Name</label>
            <input type="text" class="form-control" name="name" id="inputNome" value="{{ old('name', $estampa->name) }}">
            @error('name')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputDescription">Description</label>
            <textarea class="form-control" name="description" id="inputDescription" rows="5">{{ old('description', $estampa->description) }}</textarea>
            @error('description')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputFoto">Upload photo</label>
            <input type="file" class="form-control" name="image_url" id="inputFoto">
            @error('image_url')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a href="{{ route('catalogo.edit', ['
