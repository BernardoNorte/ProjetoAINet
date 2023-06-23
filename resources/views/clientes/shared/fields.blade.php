@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

@if ($showID)
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
@endif

@if ((Auth::user()->user_type ?? '') != 'A')
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
            <input type="text" class="form-control @error('default_payment_type') is-invalid @enderror" name="default_payment_type" id="inputDefaultPaymentType"
                {{ $disabledStr }} value="{{ old('default_payment_type', $cliente->default_payment_type) }}">
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
@else
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>NIF</th>
                <th>Address</th>
                <th>Payment Type</th>
                <th>Payment Ref</th>            
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$cliente->nif}}</td>
                <div class="mb-3 form-floating">
                    <input type="hidden" name="nif" value="{{$cliente->nif}}">
                </div>
                <td>{{$cliente->address}}</td>
                <div class="mb-3 form-floating" hidden>
                    <input type="hidden" name="address" value="{{$cliente->address}}">
                </div>
                <td>{{$cliente->default_payment_type}}</td>
                <div class="mb-3 form-floating" hidden>
                    <input type="hidden" name="default_payment_type" value="{{$cliente->default_payment_type}}">
                </div>
                <td>{{$cliente->default_payment_ref}}</td>
                <div class="mb-3 form-floating" hidden>
                    <input type="hidden" name="default_payment_ref" value="{{$cliente->default_payment_ref}}">
                </div>
            </tr>
        </tbody>
    </table>
@endif


@if ((Auth::user()->user_type ?? '') == 'A')
    @if ($allowBlocked ?? true)
        <div class="mb-3">
            <div class="form-check form-switch" >
                <input type="hidden" name="blocked" value="0" {{ $disabledStr }}>
                <input type="checkbox" {{ $disabledStr }} class="form-check-input @error('blocked') is-invalid @enderror" name="blocked"
                    id="inputOpcional" {{ old('blocked', $cliente->user->blocked) ? 'checked' : '' }} value="1">
                <label for="inputOpcional" class="form-check-label">Blocked</label>
                @error('blocked')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    @endif
@else
    <div class="mb-3 form-floating" hidden>
        <input type="hidden" name="blocked" value="{{$cliente->user->blocked}}">
    </div>
@endif

