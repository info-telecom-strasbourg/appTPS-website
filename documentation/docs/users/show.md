# Get user

Renvoie les informations de l'utilisateur en fonction de son id.

## Requête

| protocole | methode | url            | token |
| --------- | ------- |----------------| ----- |
| https     | GET     | /api/user/{id} | oui   |

## Paramètres

id de l'utilisateur dans l'url exemple : /api/user/1

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
        "avatar_url": "https://app-pprd.its-tps.fr/storage/images/avatars/default.png",
        "admission_year": "2024",
        "created_at": "2023-08-06T15:35:05.000000Z",
        "updated_at": "2023-08-06T15:35:05.000000Z",
        "sector": "AUTRE",
        "birth_date": "2023-08-06T15:35:05.000000Z"
    },
    "organizations": [
        {
            "id": 1,
            "name": "Lagardesss",
            "role": "président",
            "logo_url": "https://app-pprd.its-tps.fr/storage/images/organizations/default.png"
        },
        {
            "id": 4,
            "name": "Blot S.A.R.L.",
            "role": "secrétaire",
            "logo_url": "https://app-pprd.its-tps.fr/storage/images/organizations/default.png"
        }
    ]
}
```

### Erreur

`status: 401`

```json
{
    "message": "Unauthenticated."
}
```
