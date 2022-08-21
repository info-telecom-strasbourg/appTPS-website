@extends('layouts.layout')

@section('title', 'Accueil - AppTPS')

@section('content')

<div class="page">
    <h3>JSON CAS (temporaire) : </h3>
    <p>
    @php
        $array=App\Http\Middleware\CheckCas::getAttributes();
        echo json_encode($array);
    @endphp
    </p>
    <h1>Articles :</h1>
    @foreach($articles as $article)
        <div class="article-container">
            <p><span style="float:left">{{$article['auteur']}}</span><span style="float:right"><i><small>{{$article['created_at']}}</small></i></span></p>

            <h2 id="article-titre">{{$article['asso_club']}} - {{$article['titre']}}</h2>

            <p id="article-contenu">{!!html_entity_decode(nl2br($article['contenu']))!!} 
            {{-- @if ($article['fichier'])
                <br><img id="article-image" src="{{$article['fichier']}}"/>
            @endif --}}         
            @if ($article['fichier'])
                @php
                    $article['fichier'] = str_replace("[", "", $article['fichier']);
                    $article['fichier'] = str_replace("]", "", $article['fichier']);
                @endphp
                <br>
                @foreach(array($article['fichier']) as $image)
                    <img id="article-image" src="{{$image}}"/>
                @endforeach 
            @endif
            </p>
        </div>
        <br>
    @endforeach

</div>

@endsection