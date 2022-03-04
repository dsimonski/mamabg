<form id="pregnancyEdit" class="ajaxForm" action="{{ route('user.pregnancy.update', ['pregnancy' => $pregnancy->id]) }}"
    method="POST">
    @csrf
    @method('PUT')
    @include('pregnancy.partials.form')
    <div><input type="submit" value="Запази!" class="btn btn-primary btn-block"></div>
</form>
