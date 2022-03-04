@extends('layouts.app')

@section('title', 'Добави Потребител')

@section('content')

<h1 class="mb-5">Добави потребител</h1>

<form action="{{ route('users.store') }}" method="POST">
    @csrf

    @include('users.partials.form')

    <div><input type="submit" value="Добави!" class="btn btn-primary btn-block"></div>
</form>

@endsection
