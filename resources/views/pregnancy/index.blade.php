<h3>Бременност:</h3>

@if(isset($userPregnancy) && !empty($userPregnancy))

<table class="table">
    <thead>
        <tr>
            <th scope="col">Деца</th>
            <th scope="col">Дата на термина</th>
            <th scope="col">Дни до термина</th>
            <th scope="col" class="text-right">&nbsp;</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>
                {{ count($userPregnancy->pregnancyChildren) }} дете/деца
                <br>
                @foreach ($userPregnancy->pregnancyChildren as $child)
                {{ isset($pregnancyChildrenGenders[$child->gender]) ? $pregnancyChildrenGenders[$child->gender] : ''
                }}<br>
                @endforeach
            </td>
            <td>{{ $userPregnancy->expected_date }}</td>
            <td>
                Дни до термина: {{ $userPregnancy->pregnancy_expected_remianing_days }}
                <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar"
                        style="width: {{ ceil((280  - $userPregnancy->pregnancy_expected_remianing_days) / 280 * 100) }}%"
                        aria-valuenow="{{ ceil((280  - $userPregnancy->pregnancy_expected_remianing_days) / 280 * 100) }}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </td>
            <td class="text-right">

                <a href="#" id="editPregnancy" class="openModalForm btn btn-primary"
                    data-title="Промени данните за бременността"
                    data-href="{{ route('user.pregnancy.edit', ['pregnancy' => $userPregnancy->id]) }}"
                    data-id="{{ $userPregnancy->id }}">
                    Редактирай бременността!
                </a>

                <a href="#" id="deltePregnancy" class="deleteModal btn btn-danger" data-title="Изтрий бременността!"
                    data-href="{{ route('user.pregnancy.destroy', ['user' => $userPregnancy->user_id, 'pregnancy' => $userPregnancy->id ]) }}">
                    Изтрий бременността!
                </a>
            </td>
        </tr>

    </tbody>
</table>
@else

<p class="mb-5">
    Към този момент няма добавенa бременност!
</p>
@endif
