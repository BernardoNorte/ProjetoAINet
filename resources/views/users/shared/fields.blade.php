@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputNome"
        {{ $disabledStr }} value="{{ old('name', $user->name) }}">
    <label for="inputNome" class="form-label">Name</label>
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail"
        {{ $disabledStr }} value="{{ old('email', $user->email) }}">
    <label for="inputEmail" class="form-label">Email</label>
    @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
@if ($showBlocked)
    <div class="mb-3">
        <div class="form-check form-switch" {{ $disabledStr }}>
            <input type="hidden" name="blocked" value="0">
            <input type="checkbox" class="form-check-input @error('blocked') is-invalid @enderror" name="blocked"
                id="inputOpcional" {{ $disabledStr }} {{ old('blocked', $user->blocked) ? 'checked' : '' }} value="1">
            <label for="inputOpcional" class="form-check-label">Blocked</label>
            @error('blocked')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
@endif
@if ($showUserType)
    <div class="mb-3 form-floating">
        <select class="form-select @error('user_type') is-invalid @enderror" name="user_type" id="inputUserType">
            <option {{ $disabledStr }} {{ old('user_type', $user->user_type) == 'A' ? 'selected' : '' }} value="A">Admin
            </option>
            <option {{ $disabledStr }} {{ old('user_type', $user->user_type) == 'E' ? 'selected' : '' }} value="E">Employee
            </option>
        </select>
        <label for="inputUserType" class="form-label">User Type</label>
        @error('user_type')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
@endif