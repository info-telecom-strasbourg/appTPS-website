# Création de compte

Créer un nouvel utilisateur dans la base de données de l'application et dans la base de données du BDE et envoie un mail de confirmation à l'utilisateur.

## Requête

| protocole | methode | url           | token |
| --------- | ------- | ------------- | ----- |
| https     | POST    | /api/register | no    |

## Paramètres

| nom                   | type    | contraintes                | obligatoire | description                                   |
| --------------------- | ------- | -------------------------- | ----------- | --------------------------------------------- |
| user_name             | string  | min:3, max:30, unique      | non         | Nom de l'utilisateur                          |
| last_name             | string  | min:3, max:255             | oui         | Nom de famille de l'utilisateur               |
| first_name            | string  | min:3, max:255             | oui         | Prénom de l'utilisateur                       |
| sector                | integer | exists                     | oui         | Filiére de l'utilisateur                      |
| email                 | string  | email, max:255, unique     | oui         | Email de l'utilisateur                        |
| phone                 | string  | min:3, max:10, unique      | non         | Numéro de téléphone de l'utilisateur          |
| promotion_year        | integer | min:2000, max:3000         | non         | Année de promotion de l'utilisateur           |
| password              | string  | Vérification dans le front | oui         | Mot de passe de l'utilisateur                 |
| password_confirmation | string  | Vérification dans le front | oui         | Confirmation du mot de passe de l'utilisateur |

## Réponses

### Succès

`status: 201`

```json
{
    "user": {
        "id": 1,
        "user_name": "user_name",
        "last_name": "last_name",
        "first_name": "first_name",
        "sector": 1,
        "email": "email",
        "phone": "phone",
        "promotion_year": 2020,
        "created_at": "2020-12-12T00:00:00.000000Z",
        "updated_at": "2020-12-12T00:00:00.000000Z"
    },
    "token": "token"
}
```

### Erreur

`status: 422`

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email has already been taken."],
        "user_name": ["The user name has already been taken."]
    }
}
```

---

# Connexion

Connecte un utilisateur à l'application et renvoie un token d'authentification.

## Requête

| protocole | methode | url        | token |
| --------- | ------- | ---------- | ----- |
| https     | POST    | /api/login | no    |

## Paramètres

| nom      | type   | contraintes                | obligatoire | description                   |
| -------- | ------ | -------------------------- | ----------- | ----------------------------- |
| email    | string | email, max:255, exists     | oui         | Email de l'utilisateur        |
| password | string | Vérification dans le front | oui         | Mot de passe de l'utilisateur |

## Réponse

### Succès

`status: 200`

```json
{
    "user": {
        "id": 1,
        "user_name": "user_name",
        "last_name": "last_name",
        "first_name": "first_name",
        "sector": 1,
        "email": "email",
        "phone": "phone",
        "promotion_year": 2020,
        "created_at": "2020-12-12T00:00:00.000000Z",
        "updated_at": "2020-12-12T00:00:00.000000Z"
    },
    "token": "token"
}
```

### Erreur

`status: 401`

```json
{
    "message": ["mauvais identifiants"]
}
```

# Déconnexion

Déconnecte un utilisateur de l'application et invalide son token d'authentification.

## Requête

| protocole | methode | url         | token |
| --------- | ------- | ----------- | ----- |
| https     | POST    | /api/logout | oui   |

## Paramètres

Aucun

## Réponse

### Succès

`status: 200`

```json
{
    "message": "Successfully logged out"
}
```

### Erreur

pas d'erreur possible

# Mot de passe oublié

Envoie un email de réinitialisation de mot de passe à l'utilisateur.

## Requête

| protocole | methode | url                  | token |
| --------- | ------- | -------------------- | ----- |
| https     | POST    | /api/forgot-password | non   |

## Paramètres

| nom   | type   | contraintes | obligatoire | description            |
| ----- | ------ | ----------- | ----------- | ---------------------- |
| email | string | email       | oui         | Email de l'utilisateur |

## Réponse

### Succès

`status: 200`

```json
{
    "message": "Reset email link send"
}
```

### Erreur

`status: 404`

```json
{
    "message": "Email not found"
}
```

# Envoie de mail de vérification

Envoie un email de vérification à l'utilisateur.

## Requête

| protocole | methode | url                                  | token |
| --------- | ------- | ------------------------------------ | ----- |
| https     | POST    | /api/email/verification-notification | oui   |

## Paramètres

Aucun

## Réponse

### Succès

`status: 200`

```json
{
    "message": "Verification link sent"
}
```

### Erreur

`status: 400`

```json
{
    "message": "Email is already verified"
}
```
