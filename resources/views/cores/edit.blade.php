@extends('layout')
@section('title', 'Alterar Cor')
@section('content')


<form method="POST" action="{{ route('cores.update', ['cor' => $cor]) }}" class="form-group"
    enctype="multipart/form-data">
    @csrf

    @method('PUT')
        {{-- <input type="hidden" name="id" value="{{ $cor->id }}"> --}}

        <div class="form-group">
            <img src="{{$cor ? asset('storage/tshirt_base/' . $cor->codigo. ".jpg") : asset('img/default_img.png') }}" alt="Foto do cliente"  class="img-profile" style="width:150px;height:150px">
        </div>

        <div class="form-group">
            <label for="inputNome">Cor</label>
            <input type="text" class="form-control" name="nome" id="inputNome"
                value="{{ old('nome', $cor->nome) }}">
            @error('nome')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputNome">Código</label>
            <input type="text" class="form-control" name="nome" id="inputNome"
                value="{{ old('nome', $cor->codigo) }}">
            @error('nome')
                <div class="small text-danger">{{ $message }}</div>
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
            <a href="{{ route('cores.index') }}" class="btn btn-secondary">Cancel</a>
        </div>

</form>
@endsection
