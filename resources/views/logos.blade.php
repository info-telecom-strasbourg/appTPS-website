@extends('layouts.layout')

@section('title', 'Logos des clubs et assos - AppTPS')

@section('content')

<div class="logos">
	<h1>Logos des clubs et assos</h1>
	<p>Cliquer dessus pour télécharger le logo</p>
	@if (session()->get('cas_role')=="admin")
		<h1>	
			<a href="https://app.its-tps.fr/logo-manager">
            <i class="fa-solid fa-pencil" id="logos-edit"></i>
        	</a>
		</h1>
	@endif
	<br>
    <?php
		$files = glob("logo/*.{png}", GLOB_BRACE);
		foreach($files as $file)
		{
			echo '<a href="' . getenv('APP_URL') . '/' . $file . '" download="' . basename($file) . '"><img src="' . $file . '" id="logos-image"></a>';
		}
	?>
	<script>
		document.querySelector('select[name=file]').addEventListener('change', (event) => {
			location.href = event.target.value;
		});
	</script>
</div>

@endsection