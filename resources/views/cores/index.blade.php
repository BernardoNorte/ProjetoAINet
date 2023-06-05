@extends('layout')
@section('title','Cores')

@section('content')

    <table class="table">
        <thead>
            <tr>
                <th>Preview</th>
                <th>Cor</th>
                <th>Código</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cores as $cor)
                {{-- {{dd($cores)}} --}}
                <tr>
                    <td>
                        <img src="{{$cor ? asset('storage/tshirt_base/' . $cor->codigo. ".jpg") : asset('img/default_img.png') }}" alt="Foto do cliente"  class="img-profile" style="width:64px;height:64px">
                    </td>
                    <td>{{$cor->nome}}</td>
                    <td>{{$cor->codigo}}</td>
                    <td>

                        <div class="dropdown show">
                            <a class="btn btn-primary dropdown-toggle btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Acções
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                              <a class="dropdown-item" href="{{route('cores.edit', ['cor' => $cor->codigo])}}">Editar</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="{{route('cores.edit', ['cor' => $cor->codigo])}}">Eliminar</a>
                            </div>
                          </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $cores->withQueryString()->links() }}
@endsection

