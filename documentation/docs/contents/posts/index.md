# afficher les posts

Affiche tout les posts en fonction des paramètres de filtrage donnés

## Requête

| protocole | methode | url       | token |
| --------- | ------- | --------- | ----- |
| https     | GET     | /api/post | oui   |

## Paramètres

#### per_page :
Nombre de posts par page
#### page :
Numéro de la page
### category_id :
Id de la catégorie
### organization_id :
Id de l'organisation
### user_id :
Id de l'utilisateur
### user_name :
Nom de l'utilisateur ou de l'association
### search :
Recherche par mot clé ou phrase

#### exemple :
Sous la forme https://app-pprd.its-tps.fr/api/post?per_page=3&page=1?category_id=1


## Réponses

````json
{
    "data": [
        {
            "id": 1,
            "body": "Ceci est le contenu du premier post",
            "uploaded_since": "Il y a 2 jours",
            "uploaded_at": "2023-12-27T16:43:39.000000Z",
            "user_id": 2,
            "organization_id": 1,
            "category": [],
            "created_at": "2023-12-27T16:43:39.000000Z",
            "updated_at": "2023-12-27T16:43:39.000000Z",
            "reaction_count": 0,
            "has_reacted": "👍",
            "comment_count": 0,
            "medias": [
                {
                    "id": 1,
                    "url": "/chemin/vers/image.jpg",
                    "type": "image"
                }
            ],
            "author": {
                "is_organization": true,
                "id": 2,
                "name": "Nom complet de l'utilisateur",
                "short_name": null,
                "user_name": "Nom d'utilisateur",
                "logo_url": "/chemin/vers/avatar.jpg"
            }
        },
        {
            "id": 2,
            "body": "Ceci est le contenu du deuxième post",
            "user_id": 3,
            "organization_id": 1,
            "category":[
                {
                    "name": "Admis 2023"
                },
                {
                    "name": "Admis 2024"
                }
            ],
            "created_at": "2023-12-27T16:44:27.000000Z",
            "updated_at": "2023-12-27T16:44:27.000000Z",
            "reaction_count": 0,
            "has_reacted": "👍",
            "comment_count": 0,
            "author": {
                "is_organization": true,
                "id": 3,
                "name": "Nom complet de l'utilisateur",
                "short_name": null,
                "user_name": "Nom d'utilisateur",
                "logo_url": "/chemin/vers/avatar.jpg"
            }
        }
    ],
    "meta": {
        "total": 2,
        "per_page": 3,
        "current_page": 1,
        "last_page": 1,
        "first_page_url": "/api/posts?page=1&per_page=3",
        "last_page_url": "/api/posts?page=1&per_page=3",
        "next_page_url": null,
        "prev_page_url": null,
        "path": "/api/posts",
        "from": 1,
        "to": 2,
        "in_page": 2
    }
}

````

### succès

`status: 200`
