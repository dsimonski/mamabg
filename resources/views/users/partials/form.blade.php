<div class="form-group">
    <label for="name">Име</label>
    <input id="name" type="text" name="name" class="form-control"
        value="{{ old('name', optional($user ?? null)->name) }}">
</div>

<div class="formErrorHoder">
    @if($errors->any())
    @foreach($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
        {{ $error }}
    </div>
    @endforeach
    @endif
</div>
