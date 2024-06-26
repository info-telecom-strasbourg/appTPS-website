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
        "promotion_year": "2024",
        "created_at": "2023-08-06T15:35:05.000000Z",
        "updated_at": "2023-08-06T15:35:05.000000Z",
        "sector": "AUTRE",
        "birth_date": "2023-08-06T15:35:05.000000Z"
    },
    "posts": {
        "data": [
            {
                "id": 1,
                "title": "test",
                "content": "test",
                "user_id": 1,
                "created_at": "2023-08-06T15:35:05.000000Z",
                "updated_at": "2023-08-06T15:35:05.000000Z",
                "deleted_at": null,
                "media": [
                    {
                        "id": 1,
                        "url": "https://app-pprd.its-tps.fr/storage/images/posts/default.png",
                        "type": "image",
                        "post_id": 1
                    },
                    {
                        "id": 2,
                        "url": "https://app-pprd.its-tps.fr/storage/images/posts/default.png",
                        "type": "image",
                        "post_id": 1
                    }
                ],
                "author": {
                    "id": 1,
                    "last_name": "bergamini",
                    "first_name": "enzo",
                    "user_name": "zozoLeZozo",
                    "email": "email@email.com"
                }
            }
        ],
        "meta": {
            "current_page": 1,
            "from": 1,
            "last_page": 1,
            "path": "https://app-pprd.its-tps.fr/api/posts",
            "per_page": 10,
            "to": 1,
            "total": 1
        }
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
