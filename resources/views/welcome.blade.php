@extends('layouts.layout')

@section('title', 'Accueil - AppTPS')

@section('content')

<div class="page">
    <!-- <h3>JSON CAS (temporaire) : </h3>
    <p>
    @php
        $array=App\Http\Middleware\CheckCas::getAttributes();
        echo json_encode($array);
    @endphp
    </p> -->
    <h1>Articles :</h1>
    @foreach($articles as $article)
    <div class="article-container">
        <p><span style="float:left; font-size:1.5rem">{{$article['auteur']}} - {{$article['asso_club']}}</span><span style="float:right"><i><small>{{$article['created_at']}}</small></i></span></p>

        <h2 id="article-titre">{{$article['titre']}}</h2>

        <p id="article-contenu">{!!html_entity_decode(nl2br($article['contenu']))!!}
            @if ($article['fichiers'])
            @php
            $article['fichiers'] = str_replace("[", "", $article['fichiers']);
            $article['fichiers'] = str_replace("]", "", $article['fichiers']);
            $article['fichiers'] = str_replace("\"", "", $article['fichiers']);
            $article['fichiers'] = str_replace("\"", "", $article['fichiers']);
            $fichiers = explode(",", $article['fichiers']);
            @endphp
            <br><br>
            @foreach($fichiers as $image)
            <img id="article-image" src="{{$image}}" />
            @endforeach
            @endif
        </p>
    </div>
    <br>
    @endforeach

</div>

@endsection