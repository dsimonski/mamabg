<div class="form-group">
    <label for="expected_date">Очаквана рожденна дата (дата на термина)</label>
    <input id="expected_date" type="date" name="expected_date" class="form-control"
        value="{{ old('name', optional($pregnancy ?? null)->expected_date) }}">
</div>

<div class="form-group">
    <label>Очакван брой деца</label>
    <select class="form-control" name="gender" id="pregnancyChild">
        @for($i = 1; $i <= 5; $i++) <option value="{{ $i }}" {{ isset($pregnancyChildren) &&
            count($pregnancyChildren)==$i ? 'selected' : '' }}>
            {{ $i }}
            </option>
            @endfor
    </select>
</div>

<div id="childrenHolder">
    @if(isset($pregnancyChildren))
    @foreach($pregnancyChildren as $k => $v)
    <div class="form-group">
        <label>Пол на дете
            <span class="pregnancyChildNumber">
                {{ count($pregnancyChildren) > 1 ? $k + 1:''}}
            </span>
        </label>
        <select class="form-control" name="gender[]">
            @foreach($genders as $gender => $label)
            <option value="{{ $gender }}" {{ $v===$gender ? 'selected' : '' }}>
                {{ $label }}
            </option>
            @endforeach
        </select>
    </div>
    @endforeach
    @else
    <div class="form-group">
        <label>Пол на дете<span class="pregnancyChildNumber"></span></label>
        <select class="form-control" name="gender[]">
            @foreach($genders as $gender => $label)
            <option value="{{ $gender }}" {{ optional($children ?? null)->gender !== $gender ?: 'selected' }}>
                {{ $label }}
            </option>
            @endforeach
        </select>
    </div>
    @endif

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
