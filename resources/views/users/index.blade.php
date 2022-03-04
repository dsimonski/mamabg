@extends('layouts.app')

@section('title', 'Потребители')

@section('content')

<h1 class="mb-5">Потребители</h1>

@if(count($users))
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Име</th>
            <th scope="col">Брой деца</th>
            <th scope="col">Бременност</th>
            <th scope="col">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key => $user)
        <tr>
            <th scope="row">{{ $key + 1 }}</th>
            <td>
                <a href="{{ route('users.show', ['user' => $user->id]) }}">
                    {{ $user->name }}
                </a>
            </td>
            <td>{{ $user->count_childs }}</td>
            <td class="text-center">
                @if($user->count_pregnancy >0)
                Да
                <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar"
                        style="width: {{ ceil((280  - $user->pregnancy_expected_remianing_days) / 280 * 100) }}%"
                        aria-valuenow="{{ ceil((280  - $user->pregnancy_expected_remianing_days) / 280 * 100) }}"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                @else
                Не
                @endif

            </td>
            <td class="text-right">
                <a href="{{ route('users.show', ['user' => $user->id]) }}" class="btn btn-primary">
                    Виж / Редактирай Потребителя!
                </a>

                <a href="#" id="delteUser" class="deleteModal btn btn-danger" data-title="Изтрий потребителя!"
                    data-href="{{ route('users.destroy', ['user' => $user->id]) }}" data-id="{{ $user->id }}">
                    Изтрий потребителя!
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
Към този момент няма потребители!
@endif

@endsection
