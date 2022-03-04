<form id="childrenEdit" class="ajaxForm" action="{{ route('user.children.update', ['children' => $children->id]) }}"
    method="POST">
    @csrf
    @method('PUT')
    @include('children.partials.form')
    <div><input type="submit" value="Редактирай!" class="btn btn-primary btn-block"></div>
</form>
