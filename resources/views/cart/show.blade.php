@extends('template.layout')
@section('titulo', 'Cart')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Private Space</li>
        <li class="breadcrumb-item active">Cart</li>
    </ol>
@endsection
@section('main')

    <div>
        <h3>T-shirts in Cart</h3>
    </div>

    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Photo</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Color</th>
                <th>Price per</th>
                <th>SubTotal</th>
                <th></th>
                <th class="button-icon-col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $row)
                <tr>
                    <td>{{ $row['name'] }} </td>
                    <td><img src="{{$row['image'] ? asset('storage/tshirt_images/' . $row['image']) : asset('img/default_img.png') }}" alt="Foto da Estampa"  style="width:80px;height:80px"></td>
                    {{-- <td>{{$row['image']}}</td> --}}
                    <td>{{ $row['size'] }} </td>
                    <td>{{ $row['quantity'] }} </td>
                    <td>{{ $row['color'] }} </td>
                    <td>{{ $row['price_per'] }} €</td>
                    <td>{{ $row['total'] }} €</td>
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
                            <input type="submit" value="Decrement">
                        </form>
                    </td>
                    <td class="button-icon-col">
                        <form method="POST" action="{{ route('cart.remove', ['estampa' => $row['id'], 'size' => $row['size']]) }}">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" name="removeFromCart" class="btn btn-danger">
                                <i class="fas fa-remove"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-4 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" name="ok" form="formStore"> Confirm Cart</button>
        <button type="submit" class="btn btn-danger ms-3" name="clear" form="formClear"> Clear Cart</button>
    </div>
    <form id="formClear" method="POST" action="{{route('cart.destroy')}}" class="d-none">
        @csrf 
        @method('delete')
    </form>
@endsection

