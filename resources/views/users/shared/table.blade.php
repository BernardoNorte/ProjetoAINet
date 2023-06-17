<table class="table">
    <thead class="table-dark">
        <tr>
            <th>Photo</th>
            <th>Name</th>
            @if ($showContatos)
                <th>E-Mail</th>
            @endif
            <th>User Type</th>
            <th>Blocked</th>
            @if ($showDetail)
                <th class="button-icon-col"></th>
            @endif
            
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                @if ($showPhoto)
                    <td witdth="45">
                        <img src="{{ $user->fullPhotoUrl }}" alt="Avatar" class="bg-dark rounded-circle" width="45" height="45">
                    </td>
                @endif
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->user_type}}</td>
                <td>{{$user->blocked}}</td>
                <td></td>
                @if ($showDetail)
                    <td class="button-icon-col"><a class="btn btn-secondary"
                            href="{{ route('users.show', ['user' => $user]) }}">
                            <i class="fas fa-eye"></i></a></td>
                @endif
                
            </tr>
        @endforeach
    </tbody>
</table>
