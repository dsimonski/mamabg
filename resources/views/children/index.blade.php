<h3>Деца:</h3>

@if(count($userChildren))

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Име</th>
            <th scope="col">Пол</th>
            <th scope="col">Рожденна дата</th>
            <th scope="col">Възраст</th>
            <th scope="col" class="text-right">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userChildren as $key => $userChild)
        <tr>
            <th scope="row">{{ $key + 1}}</th>
            <td>{{ $userChild->name }}</td>
            <td>{{ isset($childrenGenders[$userChild->gender]) ? $childrenGenders[$userChild->gender] : '' }}</td>
            <td>{{ $userChild->birthday }}</td>
            <td>
                @if($userChild->user_months >= 12)
                {{ floor($userChild->user_months/12) }} години
                @elseif($userChild->user_months > 0)
                {{ $userChild->user_months }} месеца
                @else
                {{ $userChild->user_days }} дни
                @endif
            </td>
            <td class="text-right">

                <a href="#" id="editChild" class="openModalForm btn btn-primary" data-title="Промени данните за детето"
                    data-href="{{ route('user.children.edit', ['children' => $userChild->id]) }}"
                    data-id="{{ $userChild->id }}">
                    Редактирай детето!
                </a>

                <a href="#" id="delteUser" class="deleteModal btn btn-danger" data-title="Изтрий детето!"
                    data-href="{{ route('user.children.destroy', ['user' => $userChild->user_id, 'children' => $userChild->id ]) }}">
                    Изтрий детето!
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else

<p class="mb-5">
    Към този момент няма добавени деца!
</p>
@endif
