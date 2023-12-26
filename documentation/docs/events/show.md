# Afficher un événement

Affiche un événement en fonction de son ID

## Requête

| protocole | methode | url             | token |
| --------- | ------- | --------------- | ----- |
| https     | GET     | /api/event/{id} | oui   |

## Paramètres

-   **id** : ID de l'événement à afficher (integer) à mettre dans l'url exemple : `/api/event/1``

## Réponses

#### Succès

`status: 200`

```json
{
    "data": {
        "title": "Consequatur dolor molestias rerum non et repellat nisi.",
        "description": "Consequatur laudantium ipsa et aliquam vitae vitae tempore. Animi dolore eum ut atque quo consectetur. Dolore corporis qui at facere. Minus accusamus rerum qui vero et.",
        "start_at": "2023-08-06 11:33:19",
        "end_at": "2023-08-06 11:36:42",
        "location": "5413 Brown Village Apt. 865\nNew Mariamstad, FL 16176-6230",
        "color": "#bc8a01",
        "author": {
            "is_organization": false,
            "id": 1,
            "name": "enzo bergamini",
            "short_name": null,
            "logo_url": "https://app-pprd.its-tps.fr/storage/images/avatars/default.png"
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

`status: 404`

```json
{
    "message": "Event not found"
}
```
