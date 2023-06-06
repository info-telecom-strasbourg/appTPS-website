@extends('layouts.layout')

@section('extra-js')

    <script>
        tinymce.init({
            selector: "#contenu",
            plugins: "lists emoticons link",
            toolbar: "emoticons | bold italic underline | alignleft aligncenter | numlist bullist | code | link",
            toolbar_location: "top",
            menubar: true,
            default_link_target: '_blank',
            link_assume_external_targets: 'https',
            link_default_protocol: 'https'
        });
    </script>

@endsection

@section('title', 'Création article - AppTPS')

@section('content')

    <div class="container">
        <!-- Confirmation article has been sent -->
        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
            </div>
        @endif
        @if (isset($modify))
            <form action="/modify-article" method="POST" enctype="multipart/form-data" id="article">
                @csrf
                <h1>Modifie ton article</h1>
            @else
                <form action="/send-article" method="POST" enctype="multipart/form-data" id="article">
                    @csrf
                    <h1>Rédige ton article</h1>
        @endif

        <div class="field">
            <label for="titre"><span style="color: red;">*</span> Titre :</label>
            <input type="text" class="@error('titre') is-invalid @enderror" id="titre" name="titre" required
                placeholder="Entre le titre de ton article" value="{{ old('titre') }}{{ $modify['titre'] ?? '' }}"
                autocomplete="off" />
            <small></small>
        </div>
        @error('titre')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="field">
            <label for="auteur"><span style="color: red;">*</span> Auteur :</label>
            <input type="text" class="@error('auteur') is-invalid @enderror" id="auteur" name="auteur" required
                placeholder="Entre l'auteur de ton article" value="{{ old('auteur') }}{{ $modify['auteur'] ?? '' }}" />
            <small></small>
        </div>
        @error('auteur')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="field">
            <label for="email"><span style="color: red;">*</span> Email :</label>
            <input type="email" class="@error('email') is-invalid @enderror" id="email" name="email" readonly
                required placeholder="Entre ton adresse mail" value="{{ session()->get('cas_mail') }}" />
            <small></small>
        </div>
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="field">
            <label for="contenu"><span style="color: red;">*</span> Contenu :</label>
            <textarea maxlenght="65535" class="@error('contenu') is-invalid @enderror" id="contenu" name="contenu" rows="4"
                cols="50">{{ old('contenu') }}{{ $modify['contenu'] ?? '' }}</textarea>
        </div>
        @error('contenu')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="field">
            <label for="asso_club"><span style="color: red;">*</span> Pour quel club / asso écris-tu ?</label>
            <select name="asso_club" id="asso_club" required>
                <option value="{{ old('asso_club') }}{{ $modify['asso_club'] ?? '' }}">
                    {{ old('asso_club') ?? '' }}{{ $modify['asso_club'] ?? 'En choisir un(e)...' }}</option>
                <?php
                $files = glob('logo/*.{png}', GLOB_BRACE);
                foreach ($files as $file) {
                    echo '<option value="' . basename($file, '.png') . '">' . basename($file, '.png') . '</option>';
                }
                ?>
            </select>
            <script>
                document.querySelector('select[name=file]').addEventListener('change', (event) => {
                    location.href = event.target.value;
                });
            </script>
            <small></small>
        </div>
        @if (!isset($modify))
            <div class="field">
                <label for="fichier">Ajoute une image pour illustrer ton article :</label>
                <input type="file" class="@error('fichiers.*') is-invalid @enderror" name="fichiers[]" value="fichiers"
                    id="fichiers" accept="image/png,image/gif,image/jpeg" multiple>
            </div>
            @error('fichiers.*')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        @endif
        @if (isset($modify))
            <div class="field">
                <input type="hidden" name="id" value="{{ $id }}" />
                <button type="submit" class="full">Modifier</button>
            </div>
        @else
            <div class="field">
                <button type="submit" class="full">Envoyer</button>
            </div>
        @endif
        </form>
        <p style="margin: 0 30px"><span style="color: red;">*</span> Champ obligatoire</p><br>
    </div>

@endsection
