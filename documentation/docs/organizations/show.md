## Méthode Show - OrganizationController

La méthode `show` dans `OrganizationController` est utilisée pour récupérer et renvoyer les détails d'une organisation spécifique.

### Description

Cette méthode récupère une organisation spécifique par son ID, transforme les informations de l'organisation, ses membres et ses posts en un format spécifique, puis renvoie ces données sous forme de réponse JSON.

## Requête

| protocole | methode | url                    | token |
| --------- | ------- |------------------------| ----- |
| https     | GET     | /api/organization/{id} | oui   |

## Paramètres

id : identifiant de l'association/Club

#### per_page :
Nombre de posts par page
#### page :
Numéro de la page
#### exemple :
Sous la forme https://app-pprd.its-tps.fr/api/organization/1?per_page=3&page=1

### Réponse

La réponse est un objet JSON qui contient trois propriétés principales : `organization`, `members` et `posts`.

L'objet `organization` contient les détails de l'organisation, y compris les liens vers les réseaux sociaux et l'URL du logo.

L'objet `members` est un tableau d'objets, où chaque objet représente un membre de l'organisation.

L'objet `posts` contient un tableau de posts associés à l'organisation et des métadonnées sur la pagination des posts.

### Exemple de réponse

```json
{
    "organization": {
        "short_name": "org1",
        "name": "Organization 1",
        "description": "This is a description of the organization.",
        "website_link": "http://example.com",
        "facebook_link": "http://facebook.com/org1",
        "twitter_link": "http://twitter.com/org1",
        "instagram_link": "http://instagram.com/org1",
        "discord_link": "http://discord.com/org1",
        "email": "org1@example.com",
        "logo_url": "http://example.com/logo1.png"
    },
    "members": [
        {
            "id": 1,
            "first_name": "John",
            "last_name": "Doe",
            "avatar_url": "http://example.com/avatar1.png"
        },
        ...
    ],
    "posts": {
        "data": [
            {
                "id": 1,
                "body": "This is a post.",
                "created_since": "1 day ago",
                "color": "#FFFFFF",
                "category": "General",
                "reaction_count": 10,
                "comment_count": 2,
                "medias": [
                    {
                        "id": 1,
                        "url": "http://example.com/media1.png",
                        "type": "image"
                    },
                    ...
                ],
                "author": {
                    "is_organization": true,
                    "id": 1,
                    "name": "Organization 1",
                    "short_name": "org1",
                    "logo_url": "http://example.com/logo1.png"
                }
            },
            ...
        ],
        "meta": {
            "total": 10,
            "per_page": 5,
            "current_page": 1,
            "last_page": 2,
            "first_page_url": "http://example.com/api/organizations/1/posts?page=1&per_page=5",
            "last_page_url": "http://example.com/api/organizations/1/posts?page=2&per_page=5",
            "next_page_url": "http://example.com/api/organizations/1/posts?page=2&per_page=5",
            "prev_page_url": null,
            "path": "http://example.com/api/organizations/1/posts",
            "from": 1,
            "to": 5,
            "in_page": 5
        }
    }
}
