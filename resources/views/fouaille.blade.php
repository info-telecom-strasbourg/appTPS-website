@extends('layouts.layout')

@section('title', 'Historique Fouaille - AppTPS')

@section('content')

<div class="users">
    <h1>Historique des commandes au Fouaille de {{session()->get('username')}} : </h1>
    <br>
    <h2>Solde actuel : <span style="background-color: green; padding: 5px">{{ $fouaille['current_balance'] }} €</span></h2>
    <table>
        <thead>
            <tr>
                <td>Date</td>
                <td>prix</td>
                <td>Type de produit</td>
            </tr>
        </thead>
        <tbody>
            @foreach($fouaille['last_commands'] as $value)
            <tr>
                <td>{{$value['date']}}</td>
                @if ($value['price'] > 0)
                    <td><span style="color: green"><i class="fa-solid fa-caret-up"></i>&nbsp;&nbsp; {{$value['price']}} €</span></td>
                @else
                    <td><span style="color: red"><i class="fa-solid fa-caret-down"></i>&nbsp;&nbsp; {{$value['price']}} €</span></td>
                @endif
                <td>{{$value['name']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection