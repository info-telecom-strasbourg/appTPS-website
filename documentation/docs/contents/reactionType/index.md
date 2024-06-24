# Afficher les types de réactions

Affiche tous les types de réactions disponibles.

## Requête

| protocole | methode | url                | token |
| --------- | ------- |--------------------| ----- |
| https     | GET     | /api/reactiontype  | oui   |

## Réponses

### succès

`status: 200`

```json
{
    "data": [
        {
            "id": 1,
            "name": "like"
        },
        {
            "id": 2,
            "name": "dislike"
        },
        {
            "id": 3,
            "name": "love"
        }
    ]
}
```

