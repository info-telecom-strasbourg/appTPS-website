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
                <form action="/update-user" method="POST">
                    @csrf
                    <td>{{$value['identifiant']}}</td>
                    <td>{{$value['nom']}}</td>
                    <td>{{$value['email']}}</td>
                    <td>
                        <input type="hidden" name="identifiant" value="{{$value['identifiant']}}">
                        <!-- Rounded switch -->
                        <label class="switch">
                            <input type="checkbox" id="redacteur" name="redacteur" onClick="this.form.submit()" autocomplete="off" <?php echo ($value['redacteur'] == 1) ? "Checked" : "" ?>>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>{{$value['created_at']}}</td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection