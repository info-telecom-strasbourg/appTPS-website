# Update user

Met à jour les informations de l'utilisateur connecté (grace au token).

## Requête

| protocole | methode | url       | token |
| --------- | ------- | --------- | ----- |
| https     | PUT     | /api/user | oui   |

## Paramètres

| nom            | type    | contraintes                   | obligatoire | description                             |
| -------------- | ------- | ----------------------------- | ----------- | --------------------------------------- |
| user_name      | string  | min:3, max:255                | non         | Nom d'utilisateur de l'utilisateur      |
| phone          | string  | max:255, regex:/^[0-9]{10,}$/ | non         | Numéro de téléphone de l'utilisateur    |
| sector         | integer |                               | non         | Identifiant du secteur de l'utilisateur |
| promotion_year | string  |                               | non         | Année de promotion de l'utilisateur     |

## Réponse

### Succès

`status: 200`

```json
{
    "message": "User updated successfully",
    "data": {
        "id": 1,
        "last_name": "bergamini",
        "first_name": "enzo",
        "user_name": "zozoLeZozo",
        "email": "bergaminienzo62@gmail.com",
        "phone": "0606060606",
        "bde_id": 1,
        "avatar_url": "https://app-pprd.its-tps.fr/storage/images/avatars/default.png",
        "promotion_year": "2024",
        "created_at": "2023-08-06T15:35:05.000000Z",
        "updated_at": "2023-08-06T15:35:05.000000Z",
        "email_verified_at": "2023-08-06T15:35:05.000000Z",
        "sector": "AUTRE"
    }
}
```

### Erreur

`status: 401`

```json
{
    "message": "Unauthenticated."
}
```

`status: 422`

```json
{
    "message": "Validation failed",
    "errors": {
        "user_name": ["The user name must be at least 3 characters."],
        "phone": ["The phone format is invalid."],
        "sector": ["The sector must be an integer."],
        "promotion_year": ["The promotion year must be a string."],
        "avatar": ["The avatar must be an image."]
    }
}
```
