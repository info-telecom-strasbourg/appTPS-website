
<x-layout>
    <div class="card">
        <div class="card-header">
            <img src="/storage/images/App.svg" 
            alt="Logo de insidePSBS"
            class="logo-app"
            >
            <h1 class="title">Réinitialisation du mot de passe</h1>
        </div>
        <form class="reset-password-form" method="POST" action="{{$token.'?email='.$email}}">
            @csrf
            <input type="password" 
                class="reset-password-input"
                name="password" 
                placeholder="mot de passe"
            >
            <input type="password" 
                class="reset-password-confirmation-input"
                name="password_confirmation"
                placeholder="T'es sure que celui tu l'oublie pas ? (confirmation)">

            <button type="submit"
                class="reset-password-button"
            >
                Reset
            </button>
        </form>
    </div>
</x-layout>
