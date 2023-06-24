@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

@if($showorderID)
    <div class="mb-3 form-floating">
        <input type="number" class="form-control @error('number') is-invalid @enderror" name="number" id="inputNumber"
            {{ $disabledStr }} value="{{ old('id', $encomenda->id) }}">
        <label for="inputNumber" class="form-label">Order ID</label>
        @error('number')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
@endif
@if($showTotalPrice)
    <div class="mb-3 form-floating">
        <input type="number" class="form-control @error('total_price') is-invalid @enderror" name="total_price" id="inputTotalPrice"
            {{ $disabledStr }} value="{{ old('total_price', $encomenda->total_price) }}">
        <label for="inputTotalPrice" class="form-label">Total Price </label>
        @error('number')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>Quantity</th>
            <th>Price Per</th>
            <th>Subtotal</th>
            <th>Size</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tshirts as $tshirt)
        <tr>
            <td>{{ $tshirt->qty }}</td>
            <td>{{ $tshirt->unit_price }} €</td>
            <td>{{ $tshirt->sub_total }} €</td>
            <td>{{ $tshirt->size }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@if ((Auth::user()->user_type ?? '') == 'E')
    @if ($showStatus ?? true)
        <div class="mb-3 form-floating">
            <select class="form-control @error('status') is-invalid @enderror" name="status" id="inputStatus" {{ $disabledStr }}>
                @if ($encomenda->status === 'pending')
                    <option value="pending" {{ old('status', $encomenda->status) === 'pending' ? 'selected' : '' }} >Pending</option>
                    <option value="paid" {{ old('status', $encomenda->status) === 'paid' ? 'selected' : '' }}>Paid</option>
                @else if ($encomenda->status === 'paid')
                    <option value="paid" {{ old('status', $encomenda->status) === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="closed" {{ old('status', $encomenda->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                @endif
            </select>
            <label for="inputStatus" class="form-label">Status</label>
            @error('status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    @endif
@else 
    <div class="mb-3 form-floating">
        <select class="form-control @error('status') is-invalid @enderror" name="status" id="inputStatus" {{ $disabledStr }}>
            <option value="pending" {{ old('status', $encomenda->status) === 'pending' ? 'selected' : '' }} >Pending</option>
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



