@extends('layouts.layout')

@section('title', 'Historique Fouaille - AppTPS')

@section('content')

<div class="users">
    <h1>Historique des commandes au Fouaille de {{session()->get('cas_name')}} : </h1>
    <br>
    <h2>Solde actuel : <span style="background-color: green; padding: 5px">{{$fouaille[0]['new_note']}} €</span></h2>
    <table>
        <thead>
            <tr>
                <td>Date</td>
                <td>Note</td>
                <td>Delta</td>
                <td>Type de produit</td>
            </tr>
        </thead>
        <tbody>
            @foreach($fouaille as $value)
            <tr>
                <td>{{substr($value['date_histo'], 0, 19)}}</td>
                @if ($value['new_note'] > 0)
                    <td>{{$value['new_note']}} €</td>
                @else
                    <td><span style="color: red">{{$value['new_note']}} €</span></td>
                @endif
                @if ($value['delta'] > 0)
                    <td><span style="color: green"><i class="fa-solid fa-caret-up"></i>&nbsp;&nbsp; {{$value['delta']}} €</span></td>
                @else
                    <td><span style="color: red"><i class="fa-solid fa-caret-down"></i>&nbsp;&nbsp; {{$value['delta']}} €</span></td>
                @endif
                <td>{{$value['type_produit']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection