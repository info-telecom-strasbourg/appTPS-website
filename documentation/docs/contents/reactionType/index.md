# Afficher les types de réactions

Affiche tous les types de réactions disponibles.

## Requête

| protocole | methode | url                         | token |
| --------- | ------- |-----------------------------| ----- |
| https     | GET     | /api/post/{id}/reactiontype | oui   |

## Réponses

### succès

`status: 200`

```json
{
    "data": [
        {
            "id": 1,
            "name": "like",
            "icon": "👍"
        },
        {
            "id": 2,
            "name": "dislike",
            "icon": "👎"
        },
        {
            "id": 3,
            "name": "love",
            "icon": "❤️"
        }
    ]
}
```

