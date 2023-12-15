# Créer un post

Créer un post

## Requête

| protocole | methode | url       | token |
| --------- | ------- | --------- | ----- |
| https     | POST    | /api/post | oui   |

## Paramètres

| nom             | type    | contraintes             | description                       | obligatoire |
| --------------- | ------- | ----------------------- | --------------------------------- | ----------- |
| title           | string  | min:3, max:50           | Titre du post                     | oui         |
| body            | string  | min:3, max:4000000000   | Contenu du post                   | oui         |
| organization_id | integer | exists:organizations,id | ID de l'organisation              | non         |
| event_id        | integer | exists:events,id        | ID de l'événement rataché au post | non         |
| color           | string  | regex:/^#([a-f0-9]{6}   | Couleur du post                   | non         |

## Réponses

### succès

`status: 201`

```json
{
    "message": "Post created",
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
