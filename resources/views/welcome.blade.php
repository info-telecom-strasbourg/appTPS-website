@extends('layouts.layout')

@section('title', 'Accueil - AppTPS')

@section('content')


<div class="page">
    @if (session()->get('cas_role')=="admin")
    <form action="/admin-view" method="POST">
        @csrf
        <!-- Rounded switch -->
        Vue admin :&nbsp;&nbsp;
        <label class="switch">
            <input type="checkbox" id="view" name="view" onClick="this.form.submit()" autocomplete="off" <?php echo (session()->get('admin_view') == 1) ? "Checked" : "" ?>>
            <span class="slider round"></span>
        </label>
    </form>
    @endif
    <h1>Articles :</h1>
    @foreach($articles as $article)
    @if ($article['delete'] == 1)
    @if ((session()->get('cas_role') == "admin" && session()->get('admin_view') == 1) || session()->get('cas_mail') == $article['email'])
    <div class="article-container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p style="font-size:2em">Cet article est supprimé et invisible pour le public !!</p>
            <p><small>Auteur : {{$article['email']}}</small></p>
            @include('partials.article')
        </div>
        <div id="article-gestion">
            <form action="/modify-erased-article" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$article['id']}}">
                <button type="submit" style="float:none" class="restaurer" value="1" name="restaurer">Restaurer</button>
                <button type="submit" style="float:none; margin-left: 10px" value="1" name="modifier">Modifier et restaurer</button>
                <button type="submit" style="float:none" class="supprimer" value="1" name="supprimer">Supprimer définitivement</button>
            </form>
        </div>
    </div>
    @else

    @endif
    @else
    @include('partials.article')
    @endif
    @endforeach

</div>

@endsection