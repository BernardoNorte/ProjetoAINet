<table class="table">
    <thead class="table-dark">
        <tr>
            <th>Nome</th>
            <th>NIF</th>
            <th>Address</th>
            @if ($showContatos)
                <th>E-Mail</th>
            @endif
            @if ($showDetail)
                <th class="button-icon-col"></th>
            @endif
            
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $cliente)
            <tr>
                <td>{{$cliente->user->name}}</td>
                <td>{{$cliente->nif}}</td>
                <td>{{$cliente->address}}</td>
                <td>{{$cliente->user->email}}</td>
                <td></td>
                @if ($showDetail)
                    <td class="button-icon-col"><a class="btn btn-secondary"
                            href="{{ route('clientes.show', ['cliente' => $cliente]) }}">
                            <i class="fas fa-eye"></i></a></td>
                @endif
                
            </tr>
        @endforeach
    </tbody>
</table>
