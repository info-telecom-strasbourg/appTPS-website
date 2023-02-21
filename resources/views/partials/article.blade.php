<div class="article-container">
    <p><span style="float:left; font-size:1.5rem">{{$article['auteur']}}<!--  - {{$article['asso_club']}} --><img src="logo/{{$article['asso_club']}}.png" style="height: 2em; margin-left: 8px; position: absolute; top: 12px"></span><span style="float:right"><i><small>@php echo (isset($article['updated_at'])) ? "(modifié) " . $article['updated_at'] : $article['created_at'] @endphp</small></i></span></p>

    <h2 id="article-titre">{{$article['titre']}}</h2>

    <div id="article-contenu">{!!html_entity_decode(nl2br($article['contenu']))!!}
        @if ($article['fichiers'])
            @php
                $article['fichiers'] = str_replace("[", "", $article['fichiers']);
                $article['fichiers'] = str_replace("]", "", $article['fichiers']);
                $article['fichiers'] = str_replace("\"", "", $article['fichiers']);
                $article['fichiers'] = str_replace("\"", "", $article['fichiers']);
                $fichiers = explode(",", $article['fichiers']);
            @endphp
            @foreach($fichiers as $image)
                <a href="<?php getenv('APP_URL') ?>/{{ $image }}">
                    <img id="article-image" src="{{$image}}" />
                </a> 
            @endforeach 
        @endif
    </div>
    @if (session()->get('cas_role') == "admin" && $article['supprimé'] == 0 && session()->get('admin_view') == 1 && session()->get('cas_mail') != $article['email'])
    <div id="article-gestion" style="margin-bottom:1.25em">
        <p style="float:left; font-size:0.8em"><small>Auteur : {{$article['email']}}</small></p>
        <form action="/gestion-article" method="POST" id="gestion-article">
            @csrf
            <input type="hidden" name="id" value="{{$article['id']}}">
            <button type="submit" class="supprimer" value="1" name="supprimer">Supprimer</button>
        </form>
    </div>
    @endif
    @if (session()->get('cas_mail') == $article['email'] && $article['supprimé'] == 0)
    <div id="article-gestion">
        <form action="/gestion-article" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{$article['id']}}">
            <button type="submit" style="float:none; margin-left: 10px" value="1" name="modifier">Modifier</button>
            <button type="submit" style="float:none" class="supprimer" value="1" name="supprimer">Supprimer</button>
        </form>
    </div>
    @endif
</div>