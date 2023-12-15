# Afficher un post

Affiche un post

## Requête

| protocole | methode | url            | token |
| --------- | ------- | -------------- | ----- |
| https     | GET     | /api/post/{id} | oui   |

## Paramètres

-   **id** id du post a afficher dans l'url exemple : /api/post/1

## Réponses

### succès

`status: 200`

```json
{
    "data": {
        "title": "Consequatur dolor molestias rerum non et repellat nisi.",
        "body": "Consequatur laudantium ipsa et aliquam vitae vitae tempore. Animi dolore eum ut atque quo consectetur. Dolore corporis qui at facere. Minus accusamus rerum qui vero et.",
        "event_id": 1,
        "organization_id": 1,
        "user_id": 1,
        "color": "#bc8a01"
    }
}
```
