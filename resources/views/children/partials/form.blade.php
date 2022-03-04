<div class="form-group">
    <label for="name">Име</label>
    <input id="name" type="text" name="name" class="form-control"
        value="{{ old('name', optional($children ?? null)->name) }}">
</div>

<div class="form-group">
    <label for="birthday">Рожденна дата</label>
    <input id="birthday" type="date" name="birthday" class="form-control"
        value="{{ old('name', optional($children ?? null)->birthday) }}">
</div>

<div class="form-group">
    <label>Пол</label>
    <select class="form-control" name="gender">
        @foreach($genders as $gender => $label)
        <option value="{{ $gender }}" {{ optional($children ?? null)->gender !== $gender ?: 'selected' }}>
            {{ $label }}
        </option>
        @endforeach
    </select>
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
