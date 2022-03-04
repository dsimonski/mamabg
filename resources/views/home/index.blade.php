@extends('layouts.app')

@section('title', 'Статистика')

@section('content')

<h1 class="mb-5">Статистика</h1>

<h3>Статистика по потребители</h3>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Брой потребители</th>
            <th scope="col">Брой деца</th>
            <th scope="col">Брой бременности</th>
            <th scope="col">Среден брой деца на родителите</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $users }}</td>
            <td>{{ $children }}</td>
            <td>{{ $pregnancies }}</td>
            <td>{{ $averageChildByUser }}</td>
        </tr>
    </tbody>
</table>

<h3>Статистика брой на децата, разпределени във възрастовите групи</h3>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Брой деца под 1 г.</th>
            <th scope="col">Брой деца от 1 до 6 г.</th>
            <th scope="col">Брой деца от 7 до 18г.</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $childrenByAge->child_to_1 }}</td>
            <td>{{ $childrenByAge->child_1_to_6 }}</td>
            <td>{{ $childrenByAge->child_7_to_18 }}</td>
        </tr>
    </tbody>
</table>

<h3>Статистика брой бременности по разпределени по месеци</h3>
<table class="table">
    <thead>
        <tr>
            @foreach ($pregnanciesByMonthData as $pregnancyByMonth)
            <th scope="col">{{ $pregnancyByMonth['month_name'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach ($pregnanciesByMonthData as $pregnancyByMonth)
            <th scope="col">{{ $pregnancyByMonth['pregnancies_count'] }}</th>
            @endforeach
        </tr>
    </tbody>
</table>

@endsection
