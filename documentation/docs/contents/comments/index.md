# afficher les commentaires

Affiche tout les commentaires d'un post en fonction de son parent

## Requête

| protocole | methode | url                    | token |
| --------- | ------- |------------------------| ----- |
| https     | GET     | /api/post/{id}/comment | oui   |

## Paramètres

#### parent_comment_id : 
ID du commentaire parent (optionnel, si pas de parents ne rien mettre)
#### per_page : 
Nombre de commentaires par page
#### page : 
Numéro de la page
#### exemple :
Sous la forme https://app-pprd.its-tps.fr/api/post/1/comment?per_page=3&page=1&parent_comment_id=1

## Réponses

````json
{
    "data": [
        {
            "id": 1,
            "post_id": 1,
            "user_id": 2,
            "parent_comment_id": null,
            "body": "Ceci est un commentaire.",
            "created_at": "2023-12-27T16:44:27.000000Z",
            "updated_at": "2023-12-27T16:44:27.000000Z",
            "author": {
                "is_organization": false,
                "id": 2,
                "name": "Nom complet de l'utilisateur",
                "short_name": null,
                "logo_url": "/chemin/vers/avatar.jpg"
            }
        },
        {
            "id": 2,
            "post_id": 1,
            "user_id": 3,
            "parent_comment_id": null,
            "body": "Ceci est un autre commentaire.",
            "author": {
                "is_organization": true,
                "id": 1,
                "name": "Nom de l'organisation",
                "short_name": "Nom court de l'organisation",
                "logo_url": "/chemin/vers/logo.jpg"
            }
        }
    ],
    "meta": {
        "total": 6,
        "total_same_parent_id": 2,
        "per_page": 3,
        "current_page": 1,
        "last_page": 1,
        "first_page_url": "/api/postcomments?page=1&per_page=3",
        "last_page_url": "/api/postcomments?page=1&per_page=3",
        "next_page_url": null,
        "prev_page_url": null,
        "path": "/api/postcomments",
        "from": 1,
        "to": 2,
        "in_page": 2
    }
}

````

### succès

`status: 200`
