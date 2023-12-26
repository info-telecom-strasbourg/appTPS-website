# Get user

Renvoie les informations de l'utilisateur connecté (grace au token).

## Requête

| protocole | methode | url          | token |
| --------- | ------- | ------------ | ----- |
| https     | GET     | /api/user/me | oui   |

## Paramètres

Aucun

## Réponse

### Succès

`status: 200`

```json
{
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
