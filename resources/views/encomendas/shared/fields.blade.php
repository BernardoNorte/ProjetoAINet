@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp



<table class="table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Quantity</th>
            <th>Price Per</th>
            <th>Subtotal</th>
            <th>Size</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tshirts as $tshirt)
        <tr>
            <td>{{ $encomenda->id }}
            <td>{{ $tshirt->qty }}</td>
            <td>{{ $tshirt->unit_price }} €</td>
            <td>{{ $tshirt->sub_total }} €</td>
            <td>{{ $tshirt->size }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@if ($showStatus ?? true)
    <div class="mb-3 form-floating">
        <select class="form-control @error('status') is-invalid @enderror" name="status" id="inputStatus" {{ $disabledStr }}>
            <option value="pending" {{ (old('status', $encomenda->status) === 'pending') ? 'selected' : '' }}>Pending</option>
            @if ($encomenda->status === 'paid')
                <option value="closed" {{ old('status', $encomenda->status) === 'closed' ? 'selected' : '' }}>Closed</option>
            @else
                <option value="paid" {{ old('status', $encomenda->status) === 'paid' ? 'selected' : '' }}>Paid</option>
            @endif
            <option value="canceled" {{ old('status', $encomenda->status) === 'canceled' ? 'selected' : '' }}>Canceled</option>
        </select>
        <label for="inputStatus" class="form-label">Status</label>
        @error('status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

@else 
    <div class="mb-3 form-floating">
        <select class="form-control @error('status') is-invalid @enderror" name="status" id="inputStatus" {{ $disabledStr }}>
            <option value="pending" {{ old('status', $encomenda->status) === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="paid" {{ old('status', $encomenda->status) === 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="closed" {{ old('status', $encomenda->status) === 'closed' ? 'selected' : '' }}>Closed</option>
            <option value="canceled" {{ old('status', $encomenda->status) === 'canceled' ? 'selected' : '' }}>Canceled</option>
        </select>
        <label for="inputStatus" class="form-label">Status</label>
        @error('status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
@endif



