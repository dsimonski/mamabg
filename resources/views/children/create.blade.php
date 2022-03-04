<form id="childrenEdit" class="ajaxForm" action="{{ route('user.children.store', ['user' => $user->id]) }}"
    method="POST">
    @csrf
    @include('children.partials.form')
    <div><input type="submit" value="Добави!" class="btn btn-primary btn-block"></div>
</form>
