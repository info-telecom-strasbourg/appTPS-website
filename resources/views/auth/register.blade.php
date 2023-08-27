<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inside PSBS</title>
    
    <script type="module" crossorigin src="/js/index-8ef1cc3c.js"></script>
    <link rel="stylesheet" href="/css/index-26c21b6d.css">
    <link rel="stylesheet" href="/css/main.css">
  </head>
  <body
    class="flex h-screen w-screen flex-col items-center justify-between gap-10 bg-gray-950 px-20"
  >
    <nav class="flex w-full items-center justify-center gap-5 py-7">
      <img src="/logo.png" alt="logo" class="aspect-square h-12 sm:h-16" />
      <span class="text-4xl font-bold text-neutral-50 sm:text-5xl"
        >Inside PSBS</span
      >
    </nav>
    <form
      id="container"
      class="relative flex w-full max-w-2xl flex-1 flex-col items-center justify-center overflow-x-hidden"
      method="POST"
      action="{{ route('register.store') }}"
    >

    @csrf
    @method('POST')

      <div id="step-1" class="Step">
        <h3>S'inscrire</h3>
        <div class="Scroll">
          <div class="InputContainer">
            @error('email')
              <span class="Error">{{ $message }}</span>
            @enderror
            <label for="email">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="louis.royet@me.com"
              required
            />
            <span class="Error" id="email-error"></span>
          </div>
          <div class="InputContainer">
            @error('password')
              <span class="Error">{{ $message }}</span>
            @enderror
            <label for="password">Mot de passe</label>
            <input
              type="password"
              name="password"
              id="password"
              placeholder="********"
              required
            />
            <span class="Error" id="password-error"></span>
          </div>
          <div class="InputContainer">
            @error('password_confirmation')
              <span class="Error">{{ $message }}</span>
            @enderror
            <label for="password-confirmation">Confirmer le mot de passe</label>
            <input
              type="password"
              name="password_confirmation"
              id="password-confirmation"
              placeholder="********"
              required
            />
            <span class="Error" id="password-confirmation-error"></span>
          </div>
        </div>
        <button id="next-1" type="button">Suivant</button>
      </div>

      <div id="step-2" class="Step">
        <h3>Informations personnelles</h3>
        <div class="Scroll">
          <div class="flex w-full items-center justify-center gap-3">
            <div class="InputContainer">
              @error('first_name')
                <span class="Error">{{ $message }}</span>
              @enderror
              <label for="first-name">Prénom *</label>
              <input
                type="text"
                name="first_name"
                id="first-name"
                placeholder="Louis"
                required
              />
            </div>
            <div class="InputContainer">
              @error('last_name')
                <span class="Error">{{ $message }}</span>
              @enderror
              <label for="last-name">Nom *</label>
              <input
                type="text"
                name="last_name"
                id="last-name"
                placeholder="Royet"
                required
              />
            </div>
          </div>
          <div class="InputContainer">
            @error('user_name')
              <span class="Error">{{ $message }}</span>
            @enderror
            <label for="user-name">Nom d'utilisateur *</label>
            <input
              type="text"
              name="user_name"
              id="user-name"
              placeholder="louis.royet"
            />
            <span class="Error" id="user-name-error"></span>
          </div>
          <div class="InputContainer">
            @error('phone')
              <span class="Error">{{ $message }}</span>
            @enderror
            <label for="phone">Numéro de téléphone *</label>
            <input
              type="text"
              name="phone"
              id="phone"
              placeholder="0666723073"
            />
            <span class="Error" id="phone-error"></span>
          </div>
          <div class="flex w-full items-center justify-center gap-3">
            <div class="InputContainer">
              @error('promotion_year')
                <span class="Error">{{ $message }}</span>
              @enderror
              <label for="promotion-year">Année de promotion</label>
              <input
                type="text"
                name="promotion_year"
                id="promotion-year"
                placeholder="2059"
              />
              <span class="Error" id="promotion-year-error"></span>
            </div>
            <div class="InputContainer">
              @error('sector')
                <span class="Error">{{ $message }}</span>
              @enderror
              <label for="sector">Filière</label>
              <select id="sector" name="sector">
                @foreach ($sectors as $key => $value)
                  
                  <option value="{{ $value['id'] }}">{{ $value['short_name'] . ' (' . $value['name'] . ')' }}</option>
                  
                @endforeach
              </select>
              <span class="Error" id="sector-error"></span>
            </div>
          </div>
        </div>
        <div class="flex w-full items-center justify-center gap-3">
          <button id="back-2" type="button">Précédent</button>
          <button id="next-2" type="button">Suivant</button>
        </div>
      </div>

      <div id="step-3" class="Step">
        <h3>Conditions d'utilisations</h3>
        <div class="Scroll">
          <h4>Politique de confidentialité pour l'application InsidePSBS:</h4>
          <p>
            L'application InsidePSBS a été conçue pour faciliter la
            communication associative pour les écoles de Télécom Physique
            Strasbourg (TPS) et l'école supérieure de biologie de Strasbourg
            (ESBS). Nous sommes attachés à la protection de la vie privée de nos
            utilisateurs et nous nous engageons à respecter les lois et
            réglementations applicables en matière de protection des données.
          </p>
          <h4>Collecte et utilisation des données</h4>
          <p>
            Lorsque vous utilisez l'application InsidePSBS, nous collectons
            certaines informations vous concernant, notamment votre nom, prénom,
            identifiants relatifs à votre école (id, e-mail), vos photos de
            profil, vos appartenances à un club ou une association de l'école,
            ainsi que les informations nécessaires au fonctionnement de
            l'application (identifiants de notification). Ces informations sont
            nécessaires pour assurer le bon fonctionnement de l'application et
            pour faciliter la communication entre les utilisateurs. Elles ne
            seront jamais vendues à des tiers.
          </p>
          <h4>Sécurité et confidentialité</h4>
          <p>
            Nous prenons la sécurité et la confidentialité de vos données très
            au sérieux. Nous avons mis en place des mesures de sécurité
            appropriées pour protéger vos données contre tout accès non
            autorisé, toute utilisation abusive, toute altération ou toute perte
            de données. Toutes les données sensibles sont chiffrées pour
            empêcher tout accès non autorisé. Les données sont stockées sur des
            serveurs sécurisés, qui sont régulièrement mis à jour et surveillés
            pour détecter toute violation de sécurité.
          </p>
          <h4>Vos droits</h4>
          <p>
            Vous avez le droit de consulter les données que nous avons
            collectées vous concernant et de les supprimer si vous le souhaitez.
            Pour exercer ces droits, veuillez contacter un administrateur de
            l'application.
          </p>
          <h4>Modifications de la politique de confidentialité</h4>
          <p>
            Nous nous réservons le droit de modifier cette politique de
            confidentialité à tout moment, en publiant une version mise à jour
            sur notre site web ou sur l'application. Il est de votre
            responsabilité de consulter régulièrement cette politique de
            confidentialité pour prendre connaissance des éventuelles
            modifications.
          </p>
        </div>
        <div class="flex w-full gap-2">
          <input type="checkbox" id="cgu" required />
          <label for="cgu" class="flex-1 text-neutral-50"
            >J'accepte les conditions d'utilisations</label
          >
        </div>
        <div class="flex w-full items-center justify-center gap-3">
          <button id="back-3" type="button">Précédent</button>
          <button id="next-3" type="submit">Envoyer</button>
        </div>
      </div>
    </form>
    
  </body>
</html>
