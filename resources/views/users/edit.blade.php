<form id="userEdit" class="ajaxForm" action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
    @csrf
    @method('PUT')
    @include('users.partials.form')
    <div><input type="submit" value="Редактирай!" class="btn btn-primary btn-block"></div>
</form>
