<form id="pregnancyEdit" class="ajaxForm" action="{{ route('user.pregnancy.store', ['user' => $user->id]) }}"
    method="POST">
    @csrf
    @include('pregnancy.partials.form')
    <div><input type="submit" value="Добави!" class="btn btn-primary btn-block"></div>
</form>
