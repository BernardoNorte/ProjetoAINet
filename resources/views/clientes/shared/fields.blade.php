@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="mb-3 form-floating">
        <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" id="inputNumero"
            {{ $disabledStr }} value="{{ old('id', $cliente->id) }}">
        <label for="inputNumero" class="form-label">Client ID</label>
        @error('id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
</div>
<div class="mb-3 form-floating">
        <input type="text" class="form-control @error('nif') is-invalid @enderror" name="nif" id="inputNif"
            {{ $disabledStr }} value="{{ old('nif', $cliente->nif) }}">
        <label for="inputNif" class="form-label">NIF</label>
        @error('nif')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
</div>
<div class="mb-3 form-floating">
        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="inputAddress"
            {{ $disabledStr }} value="{{ old('address', $cliente->address) }}">
        <label for="inputAddress" class="form-label">Address</label>
        @error('address')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
</div>
<div class="mb-3 form-floating">
        <select id="default_payment_type" class="form-select @error('default_payment_type') is-invalid @enderror" name="default_payment_type" required>
            <option value="VISA" {{ old('default_payment_type', 'VISA') == 'VISA' ? 'selected' : '' }}>Visa</option>
            <option value="MC" {{ old('default_payment_type', 'MC') == 'MC' ? 'selected' : '' }}>MC</option>
            <option value="PAYPAL" {{ old('default_payment_type', 'PAYPAL') == 'PAYPAL' ? 'selected' : '' }}>PayPal</option>
        </select>
        <label for="inputDefaultPaymentType" class="form-label">Payment Type</label>
        @error('default_payment_type')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
</div>
<div class="mb-3 form-floating">
        <input type="text" class="form-control @error('default_payment_ref') is-invalid @enderror" name="default_payment_ref" id="inputDefaultPaymentRef"
            {{ $disabledStr }} value="{{ old('default_payment_ref', $cliente->default_payment_ref) }}">
        <label for="inputDefaultPaymentRef" class="form-label">Payment REF</label>
        @error('default_payment_ref')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
</div>

