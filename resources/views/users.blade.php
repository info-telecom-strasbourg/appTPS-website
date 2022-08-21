@extends('layouts.layout')

@section('title', 'Utilisateurs - AppTPS')

@section('content')

<div class="users">
    <h1>Liste des utilisateurs ayant activé l'app : </h1>
    <br>
    <table>
        <thead>
            <tr>
                <td>Identifiant</td>
                <td>Nom</td>
                <td>Mail</td>
                <td>Rédacteur ?</td>
                <td>Première connexion</td>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $value)
            <tr>
                <td>{{$value['identifiant']}}</td>
                <td>{{$value['nom']}}</td>
                <td>{{$value['email']}}</td>
                <td><?php echo $var = ($value['redacteur'] == 1) ? "Oui" : "Non" ?>
                <!-- <input type="checkbox" id="redacteur" name="redacteur" autocomplete="off" <?php echo $var ? "Checked" : ""?> /> --></td>
                <td>{{$value['created_at']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection