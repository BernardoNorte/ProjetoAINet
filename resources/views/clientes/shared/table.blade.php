<table class="table">
    <thead class="table-dark">
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>NIF</th>
            <th>Address</th>
            @if ($showContatos)
                <th>E-Mail</th>
            @endif
            @if ($showDetail)
                <th class="button-icon-col"></th>
            @endif
            @if ($showRemove)
                <th class="button-icon-col"></th>
            @endif
            
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $cliente)
            <tr>
                @if ($showPhoto)
                    <td witdth="45">
                        <img src="{{ $cliente->user->fullPhotoUrl }}" alt="Avatar" class="bg-dark rounded-circle" width="45" height="45">
                    </td>
                @endif
                <td>{{$cliente->user->name}}</td>
                <td>{{$cliente->nif}}</td>
                <td>{{$cliente->address}}</td>
                <td>{{$cliente->user->email}}</td>
                @if ($showDetail)
                    <td class="button-icon-col"><a class="btn btn-secondary"
                            href="{{ route('clientes.show', ['cliente' => $cliente]) }}">
                            <i class="fas fa-eye"></i></a></td>
                @endif
                @if ($showRemove)
                    <td class="button-icon-col">
                            <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#confirmationModal"
                                data-msgLine1="Do you really want to remove <strong>&quot;{{ $cliente->user->name }}&quot;</strong>?"
                                href="{{ route('clientes.destroy', ['cliente' => $cliente]) }}">
                                <i class="fas fa-trash"></i></button>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
