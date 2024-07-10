# Récupérer les réactions d'un post

Permet de récupérer toutes les réactions d'un post spécifique.

## Requête

| protocole | methode | url                     | token |
| --------- | ------- |-------------------------| ----- |
| https     | GET     | /api/post/{id}/reaction | oui   |

## Paramètres

| nom    | type    | contraintes    | description              | obligatoire |
|--------|---------|----------------|--------------------------|-------------|
| id     | integer | exists:posts,id| ID du post               | oui         |

## Réponses

### succès

`status: 200`

```json
{
    "data": [
        {
            "reaction_type_id": 1,
            "reaction_type": "like",
            "icon": "👍", 
            "total": 10,
            "users": [
                {
                    "id": 1,
                    "name": "John Doe",
                    "avatar": "/path/to/avatar.jpg"
                },
                {
                    "id": 2,
                    "name": "Jane Doe",
                    "avatar": "/path/to/avatar.jpg"
                }
            ]
        },
        {
            "reaction_type_id": 2,
            "reaction_type": "dislike",
            "total": 5,
            "users": [
                {
                    "id": 3,
                    "name": "John Doe",
                    "avatar": "/path/to/avatar.jpg"
                },
                {
                    "id": 4,
                    "name": "Jane Doe",
                    "avatar": "/path/to/avatar.jpg"
                }
            ]
        }
    ]
}
```
