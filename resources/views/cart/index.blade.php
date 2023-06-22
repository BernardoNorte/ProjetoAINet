<table class="table">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>Photo</th>
            <th>Quantity</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($carrinho as $row)
            <tr>
                <td>{{ $row['name'] }} </td>
                <td>{{ $row['image'] }} </td>
                <td>{{ $row['qtd'] }} </td>
                <td>
                    <form action="{{route('cart.update', $row['id'])}}" method="POST">
                        @csrf 
                        @method('put')
                        <input type="hidden" name="quantidade" value="1">
                        <input type="submit" value="Increment">
                    </form>
                </td>
                <td>
                    <form action="{{route('cart.update', $row['id'])}}" method="POST">
                        @csrf 
                        @method('put')
                        <input type="hidden" name="quantidade" value="-1">
                        <input type="submit" value="Increment">
                    </form>
                </td>
                <td>
                    <form action="{{route('cart.destroy', $row['id'])}}" method="POST">
                        @csrf 
                        @method('delete')
                        <input type="hidden" value="Remove">
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
