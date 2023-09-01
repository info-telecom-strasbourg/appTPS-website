<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inside PSBS</title>
    
    <script type="module" crossorigin src="/js/index-8ef1cc3c.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js" onload="initializeFormLogic()"></script>

    <script type="module" crossorigin src="/js/main.js"></script>


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
            <label for="email">Email *</label>
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
            <label for="password">Mot de passe *</label>
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
            <label for="password-confirmation">Confirmer le mot de passe *</label>
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
            @error('birth_date')
              <span class="Error">{{ $message }}</span>
            @enderror
            <label for="birth-date">Date de naissance *</label>
            <input
              type="date"
              name="birth_date"
              id="birth-date"
              value="2000-01-01"
              required
            />
          </div>
          <div class="InputContainer">
            @error('user_name')
              <span class="Error">{{ $message }}</span>
            @enderror
            <label for="user-name">Nom d'utilisateur</label>
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
            <label for="phone">Numéro de téléphone</label>
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
        <h3>Conditions d'utilisations de InsidePSBS</h3>
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
        <h3>Charte du fouaille</h3>
        <div class="Scroll">
          <h4>PREAMBULE :</h4>
          <p>
            La présente Charte a pour objet de définir les règles d'utilisation des biens et des services du Foyer des Élèves de Télécom Physique Strasbourg. Elle présente les conditions indispensables au bon fonctionnement du Foyer et établit les engagements des membres de l'Association des Élèves le fréquentant. Réciproquement, elle établit les engagements que le Foyer prend lorsqu'il les accueille.
            Cette charte peut être sujette à modification, d'une année à l'autre, à la demande d'une des parties. La nouvelle Charte doit être validée par le Bureau des Élèves.
            Cette Charte sera signée par le Président du BDE et les Vice-présidents chargés du Foyer ainsi que par le
            membre de l'Association.
            De plus, la signature de cette charte témoigne du paiement de la cotisation au Foyer des élèves de Télécom Physique Strasbourg.
          </p>
          <h4>ARTICLE 1 :</h4>
          <p>
            Avant tout, il est indispensable que l'usager du Foyer soit adhérent de l'Association des Élèves de Télécom Physique Strasbourg, et que de ce fait, il se soit acquitté de la cotisation annuelle. Il doit à tout moment être
            capable de présenter sa carte d'adhérent à l'Association.            
          </p>
          <h4>ARTICLE 2 :</h4>
          <p>
            Chaque usager se doit de respecter le Foyer. L'abandon de déchets, la dégradation des meubles ou du matériel et le vol sont formellement interdits.
            En échange, le Foyer s'engage à mettre des poubelles à la disposition des usagers.
          </p>
          <h4>ARTICLE 3 :</h4>
          <p>
            Par contre, le Foyer ne s'engage pas à ce que le bar soit ouvert en continu. Ceci dépend de la disponibilité des barmans. Seuls les membres du BDE et les barmans sont habilités à servir et à encaisser.
            Il est interdit d'aller derrière le bar ou de pénétrer dans la petite salle derrière le bar. Seuls les membres du BDE et les barmans sont habilités à le faire. Cette salle devra rester fermée en l'absence de barman.
            Une personne ne faisant pas partie des personnes suscitées pourra passer derrière le bar uniquement lorsque’ lle viendra nettoyer la vaisselle qu'elle vient d'utiliser.
          </p>
          <h4>ARTICLE 4 :</h4>
          <p>
            Il est interdit de fumer dans le foyer. L'introduction et la détention de substances illicites sera aussi sanctionnée.
          </p>
          <h4>ARTICLE 5 :</h4>
          <p>
            Tout membre de l'Association s'engage à aider ponctuellement les barmans à nettoyer le Foyer à la demande de ces derniers.
          </p>
          <h4>ARTICLE 6 :</h4>
          <p>
            En cas de non respect de ces différentes règles par un usager, des sanctions peuvent être prises par un membre du BDE : un simple avertissement, l’aide au nettoyage, le remboursement pour bris voire la radiation
            de l'Association.
          </p>
          <h4>ARTICLE 7 :</h4>
          <p>
            Les membres du BDE et les barmans s'engagent au respect de l'usager, à l'intégrité et à la bonne tenue des comptes. Sûrs de nos intentions, forts de notre conscience, nous nous engageons, devant cette Assemblée, à être fidèles à cette Charte, nous réservant d'en juger le maintien.
          </p>
        </div>
        <div class="flex w-full gap-2">
          <input type="checkbox" id="cgu" required />
          <label for="cgu" class="flex-1 text-neutral-50"
            >J'accepte les conditions d'utilisations de insidePSBS</label
          >
          <input type="checkbox" id="cgu" required />
          <label for="cgu" class="flex-1 text-neutral-50"
            >J'accepte les conditions d'utilisations du fouaille</label
          >
        </div>
        <div class="flex w-full items-center justify-center gap-3">
          <button id="back-3" type="button">Précédent</button>
          <button id="next-3" type="submit">Envoyer</button>
        </div>
      </div>
    </form>
    
  </body>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const email_input = document.getElementById("email");
      const password_input = document.getElementById("password");
      const password_confirmation_input = document.getElementById("password-confirmation");
  
      document.getElementById("container").addEventListener("submit", function (event) {
        event.preventDefault();
  
        const email = email_input.value;
        const password = password_input.value;
        const password_confirmation = password_confirmation_input.value;
  
        if (email && password && password_confirmation && password === password_confirmation) {
          const hash_password = CryptoJS.SHA256(password + email).toString();
          const hash_password_confirmation = CryptoJS.SHA256(password_confirmation + email).toString();
  
          password_input.value = hash_password;
          password_confirmation_input.value = hash_password_confirmation;
  
          // Now, submit the form with the updated password field
          event.target.submit();
        }
      });
    });
  </script>
</html>
