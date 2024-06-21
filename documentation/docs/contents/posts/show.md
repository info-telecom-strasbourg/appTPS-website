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
        "id": 1,
        "body": "Ceci est le contenu du premier post",
        "user_id": 2,
        "organization_id": 1,
        "category": "Admis2023",
        "created_at": "2023-12-27T16:43:39.000000Z",
        "updated_at": "2023-12-27T16:43:39.000000Z",
        "reaction_count": 2,
        "media": [
            {
                "id": 1,
                "url": "/chemin/vers/image.jpg",
                "type": "image"
            },
            {
                "id": 2,
                "url": "/chemin/vers/video.mp4",
                "type": "video"
            }
        ],
        "author": {
            "is_organization": true,
            "id": 2,
            "name": "Nom complet de l'utilisateur",
            "short_name": null,
            "logo_url": "/chemin/vers/avatar.jpg"
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
    "message": "Post not found"
}
```
