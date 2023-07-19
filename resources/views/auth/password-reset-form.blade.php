
<x-layout>
    <div class="card">
        <div class="card-header">
            <img src="/storage/images/App.svg"
            alt="Logo de insidePSBS"
            class="logo-app"
            >
            <h1 class="title">Réinitialisation du mot de passe</h1>
        </div>

        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li class="error-message">{{$error}}</li>
                @endforeach
            </ul>
        @endif

        <form class="reset-password-form" method="POST" action="{{$token.'?email='.$email}}">
            @csrf
            <input type="password"
                class="reset-password-input"
                name="password"
                placeholder="mot de passe"
                required
                minlength="8"
                type="password"
            >
            <input type="password"
                class="reset-password-confirmation-input"
                name="password_confirmation"
                placeholder="T'es sure que celui là tu l'oubliera pas ? (confirmation)"
                required
                minlength="8"
                type="password"
            >

            <button type="submit"
                class="reset-password-button"
            >
                Reset
            </button>
        </form>
    </div>
</x-layout>
