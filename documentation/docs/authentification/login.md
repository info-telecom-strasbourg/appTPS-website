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
