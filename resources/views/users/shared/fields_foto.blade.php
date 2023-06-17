<img src="{{ $user->fullPhotoUrl }}" alt="Avatar" class="rounded-circle img-thumbnail">
@if ($allowUpload)
    <div class="mb-3 pt-3">
        <input type="file" class="form-control @error('file_foto') is-invalid @enderror" name="file_foto"
            id="inputFileFoto">
        @error('file_foto')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
@endif
@if (($allowDelete ?? false) && $user->photo_url)
    @if ($user->cliente)
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal"
            data-action="{{ route('clientes.foto.destroy', ['cliente' => $user->cliente]) }}"
            data-msgLine2="Do you really want to remove the photo <strong>{{ $user->name }}</strong>?">
            Delete Photo
        </button>
    @endif
@endif
@if (($allowDelete ?? false) && $user->photo_url)
    @if ($user)
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal"
            data-action="{{ route('users.foto.destroy', ['user' => $user]) }}"
            data-msgLine2="Do you really want to remove the photo <strong>{{ $user->name }}</strong>?">
            Delete Photo
        </button>
    @endif
@endif