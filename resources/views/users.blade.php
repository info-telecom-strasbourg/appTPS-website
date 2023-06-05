@extends('layouts.layout')

@section('title', 'Utilisateurs - AppTPS')

@section('content')

<div class="users">
    <h1>Liste des <span style="color: green">{{$nb_users}}</span> utilisateurs ayant activé l'app : </h1>
    <br>
    <table>
        <thead>
            <tr>
                <td>Identifiant</td>
                <td>Identifiant BDE</td>
                <td>Identifiant unistra</td>
                <td>Nom</td>
                <td>Prenom</td>
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
                    <td>{{$value->id}}</td>
                    <td>{{$value->id_bde}}</td>
                    <td>{{$value->id_unistra}}</td>
                    <td>{{$value->last_name}}</td>
                    <td>{{$value->first_name}}</td>
                    <td>{{$value->email}}</td>
                    <td>
                        <input type="hidden" name="identifiant" value="{{$value->id}}">
                        <!-- Rounded switch -->
                        <label class="switch">
                            <input type="checkbox" id="redacteur" name="redacteur" onClick="this.form.submit()" autocomplete="off" <?php echo ($value->redacteur == 1) ? "Checked" : "" ?>>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>{{$value->created_at}}</td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection