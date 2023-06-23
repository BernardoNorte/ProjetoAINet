@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp


<table class="table">
    <thead class="table-dark">
        <tr>
            <th>Size</th>
            <th>Photo</th>
            <th>Size</th>
            <th>Quantity</th>
            <th>Color</th>
            <th>Price per</th>
            <th>SubTotal</th>
            <th></th>
            <th></th>
            <th class="button-icon-col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($encomendas->tshirts as $tshirt)
            <td>{{$tshirt->size}}</td>
        @endforeach
    </tbody>
</table>
