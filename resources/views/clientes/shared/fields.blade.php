@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="d-flex justify-content-between">
    <div class="mb-3 form-floating flex-grow-1">
        <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" id="inputNumero"
            {{ $disabledStr }} value="{{ old('id', $cliente->id) }}">
        <label for="inputNumero" class="form-label">Cliente ID</label>
        @error('id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <input type="text" class="form-control @error('nif') is-invalid @enderror" name="nif" id="inputNif"
            {{ $disabledStr }} value="{{ old('nif', $cliente->nif) }}">
        <label for="inputNif" class="form-label"></label>
        @error('nif')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="inputAddress"
            {{ $disabledStr }} value="{{ old('address', $cliente->address) }}">
        <label for="inputAddress" class="form-label"></label>
        @error('address')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <input type="text" class="form-control @error('default_payment_type') is-invalid @enderror" name="default_payment_type" id="inputDefaultPaymentType"
            {{ $disabledStr }} value="{{ old('default_payment_type', $cliente->default_payment_type) }}">
        <label for="inputDefaultPaymentType" class="form-label"></label>
        @error('default_payment_type')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <input type="text" class="form-control @error('default_payment_ref') is-invalid @enderror" name="default_payment_ref" id="inputDefaultPaymentRef"
            {{ $disabledStr }} value="{{ old('default_payment_ref', $cliente->default_payment_ref) }}">
        <label for="inputDefaultPaymentRef" class="form-label"></label>
        @error('default_payment_ref')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
