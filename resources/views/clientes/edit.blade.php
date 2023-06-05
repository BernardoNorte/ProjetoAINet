@extends('template.layout')
@section('title', 'Alterar Cliente')
@section('content')


    <form method="POST" action="{{ route('clientes.update', ['cliente' => $cliente]) }}" class="form-group"
        enctype="multipart/form-data">
        @csrf

        @method('PUT')
        <input type="hidden" name="id" value="{{ $cliente->id }}">

        @if ($cliente->user->foto_url)
        <div class="form-group">
            <img src="{{ $cliente->user->foto_url ? asset('storage/fotos/' . $cliente->user->foto_url) : asset('img/default_img.png') }}"
                alt="Foto do cliente" class="img-profile" style="max-width:100%">
        </div>
        @else
        <div class="form-group">
            <img src="{{ $cliente->user->foto_url ? asset('storage/fotos/' . $cliente->user->foto_url) : asset('img/default_img.png') }}"
                alt="Foto do cliente" class="img-profile" style="width:128px;height:128px">
        </div>
        @endif


        <div class="form-group">
            <label for="inputNome">Nome</label>
            <input type="text" class="form-control" name="name" id="inputNome"
                value="{{ old('name', $cliente->user->name) }}">
            @error('name')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputNome">Email</label>
            <input type="text" class="form-control" name="email" id="inputEmail"
                value="{{ old('email', $cliente->user->email) }}">
            @error('email')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputNome">Nif</label>
            <input type="text" class="form-control" name="nif" id="inputNif" value="{{ old('nif', $cliente->nif) }}">
            @error('nif')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputNome">Endereço</label>
            <input type="text" class="form-control" name="endereco" id="inputEndereco"
                value="{{ old('endereco', $cliente->endereco) }}">
            @error('endereco')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputNome">Tipo de Pagamento</label>
            {{-- <input type="text" class="form-control" name="tipo_pagamento" id="inputTipo_pagamento" value="{{old('tipo_pagamento', $cliente->tipo_pagamento)}}" > --}}
            <select class="custom-select" id="inputTipo_pagamento" name="tipo_pagamento">

                @switch(old('tipo_pagamento', $cliente->tipo_pagamento))
                    @case('MC')
                    <option value="MC" selected>Master Card</option>
                    <option value="PAYPAL">Paypal</option>
                    <option value="VISA">Visa</option>
                    @break
                    @case('VISA')
                    <option value="MC">Master Card</option>
                    <option value="PAYPAL">Paypal</option>
                    <option value="VISA" selected>Visa</option>
                    @break
                    @case('PAYPAL')
                    <option value="MC" >Master Card</option>
                    <option value="PAYPAL" selected>Paypal</option>
                    <option value="VISA">Visa</option>
                    @break


                @endswitch




            </select>

            @error('tipo_pagamento')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputNome">Referência de Pagamento</label>
            <input type="text" class="form-control" name="ref_pagamento" id="inputRef_pagamento"
                value="{{ old('ref_pagamento', $cliente->ref_pagamento) }}">
            @error('ref_pagamento')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputNome">bloqueado</label>
            <input type="text" class="form-control" name="bloqueado" id="inputBloqueado"
                value="{{ old('bloqueado', $cliente->user->bloqueado) }}">
            @error('bloqueado')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputFoto">Upload da foto</label>
            <input type="file" class="form-control" name="foto_url" id="inputFoto">
            @error('foto')
                <div class="small text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group text-right">
            @isset($cliente->user->foto_url)
                <button type="submit" class="btn btn-danger" name="deletefoto" form="form_delete_photo">Apagar Foto</button>
            @endisset
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a href="{{ route('clientes.edit', ['cliente' => $cliente ?? '']) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    {{-- <form id="form_delete_photo" action="{{ route('clientes.foto.destroy', ['cliente' => $cliente ?? '']) }}"
        method="POST">
        @csrf
        @method('DELETE')
    </form> --}}

@endsection
