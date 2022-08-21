@extends('layouts.layout')

@section('title', 'Création article - AppTPS')

@section('content')

<div class="container">
	<!-- Confirmation article has been sent -->
	@if (session('message'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('message') }}
		</div>
	@endif
	<form action="/send-article" method="POST" enctype="multipart/form-data" id="article">
		@csrf
		<h1>Rédige ton article</h1>
		<div class="field">
			<label for="titre"><span style="color: red;">*</span> Titre :</label>
			<input type="text" id="titre" name="titre" required placeholder="Entre le titre de ton article" autocomplete="off" />
			<small></small>
		</div>
              <div class="field">
			<label for="auteur"><span style="color: red;">*</span> Auteur :</label>
			<input type="text" id="auteur" name="auteur" required placeholder="Entre l'auteur de ton article" autocomplete="off" />
			<small></small>
		</div>
		<div class="field">
			<label for="email"><span style="color: red;">*</span> Email :</label>
			<input type="email" id="email" name="email" readonly required placeholder="Entre ton adresse mail" value="{{session()->get('cas_mail')}}"/>
			<small></small>
		</div>
              <div class="field">
                  <label for="contenu"><span style="color: red;">*</span> Contenu :</label>
                  <textarea maxlenght="65535" id="contenu" required name="contenu" rows="4" cols="50"></textarea> 
		</div>
              <div class="field">
                  <label for="asso_club"><span style="color: red;">*</span> Pour quel club / asso écris-tu ?</label>
                  <select name="asso_club" id="asso_club" required>
			  <option value="">En choisir un(e)...</option>
			  <option value="ITS">ITS</option>
                    <option value="BDE">BDE</option>
                    <option value="BDS">BDS</option>
                    <option value="BDF">BDF</option>
                    <option value="Musique">Musique</option>
                    <option value="Oeno">Oeno</option>
                    <option value="Gala">Gala</option>
                    <option value="PSI">PSI</option>
                    <option value="RTS">RTS</option>
                    <option value="BDA">BDA</option>
                    <option value="BDH">BDH</option>
                    <option value="RTS">RTS</option>
                  </select>
			<small></small>
		</div>
              <div class="field">
              <label for="fichier">Ajoute une image pour illustrer ton article :</label>              
              <input type="file" name="fichier[]" value="fichier" id="fichier" accept="image/png,image/gif,image/jpeg" multiple>
              </div>
		<div class="field">
			<button type="submit" class="full">Envoyer</button>
		</div>
	</form>
	<p style="margin: 0 30px"><span style="color: red;">*</span> Champ obligatoire</p><br>
</div>

@endsection