<x-layout>
    <div class="card">
        <div class="card-header">
            <img src="/storage/images/App.svg" alt="Logo de insidePSBS" class="logo-app">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js" defer></script>
            <h1 class="title">Réinitialisation du mot de passe</h1>
        </div>
        <form class="reset-password-form" method="POST" action="{{ $token . '?email=' . $email }}">
            @csrf
            <input type="password" class="reset-password-input" name="password" placeholder="Mot de passe">
            <input type="password" class="reset-password-confirmation-input" name="password_confirmation"
                placeholder="Confirmation du mot de passe">
            <input type="email" class="email-input" name="email" value="{{ request()->get('email') }}" hidden>


            <button type="submit" class="reset-password-button">
                Reset
            </button>
        </form>
    </div>
    <script src="/js/hash.js" type="module"></script>
</x-layout>
