@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="d-flex justify-content-between">
    <div class="mb-3 form-floating flex-grow-1">
        <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" id="inputNumero"
            {{ $disabledStr }} value="{{ old('id', $cliente->id) }}">
        <label for="inputNumero" class="form-label">cliente Id</label>
        @error('id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <input type="text" class="form-control @error('nif') is-invalid @enderror" name="nif" id="inputNif"
            {{ $disabledStr }} value="{{ old('nif', $cliente->nif) }}">
        <label for="inputNif" class="form-label">Cliente NIF</label>
        @error('nif')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
