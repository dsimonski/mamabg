@extends('layouts.app')

@section('title', 'Потребители')

@section('content')

<h1 class="mb-3">Потребирел: <span class="userName">{{ $user->name }}</span></h1>

<div class="mb-5">

    <table class="table">
        <tbody>
            <tr>
                <td>
                    <a href="#" id="addChild" class="openModalForm btn btn-primary" data-title="Добави дете"
                        data-href="{{ route('user.children.create', ['user' => $user->id]) }}"
                        data-id="{{ $user->id }}">
                        Добави дете!
                    </a>
                    @if(empty($userPregnancy))
                    <a href="#" id="addPregnancy" class="openModalForm btn btn-primary" data-title="Добави бременност"
                        data-href="{{ route('user.pregnancy.create', ['user' => $user->id]) }}"
                        data-id="{{ $user->id }}">
                        Добави бременност!
                    </a>
                    @endif
                </td>
                <td class="text-right">
                    <a href="#" id="editUser" class="openModalForm btn btn-primary" data-title="Промени Потребителя"
                        data-href="{{ route('users.edit', ['user' => $user->id]) }}" data-id="{{ $user->id }}">
                        Редактирай потребителя!
                    </a>

                    <a href="#" id="delteUser" class="deleteModal btn btn-danger" data-title="Изтрий потребителя!"
                        data-href="{{ route('users.destroy', ['user' => $user->id]) }}" data-id="{{ $user->id }}">
                        Изтрий потребителя!
                    </a>
                </td>
            </tr>

        </tbody>
    </table>

</div>

<div id="userChildren">
    @include('children.index')
</div>

<div id="userPregnancy">
    @include('pregnancy.index')
</div>

@endsection
