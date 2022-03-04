<h3>
    <a href="{{ route('users.show', ['user' => $user->id]) }}">
        {{ $user->name }}
    </a>
</h3>

<div class="mb-3">

    <a href="{{ route('users.show', ['user' => $user->id]) }}" class="btn btn-warning">
        Редактирай Потребителя!
    </a>

    <a href="#" id="delteUser" class="deleteModal btn btn-outline-danger" data-title="Изтрий потребителя!"
        data-href="{{ route('users.destroy', ['user' => $user->id]) }}" data-id="{{ $user->id }}">
        Изтрий потребителя!
    </a>

</div>

<hr>
