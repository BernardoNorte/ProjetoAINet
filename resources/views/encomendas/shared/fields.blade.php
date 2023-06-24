@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp


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

