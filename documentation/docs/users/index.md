# Index User

Renvoie la liste de tous les utilisateurs.

## Requête

| protocole | méthode | url         | token |
|-----------|---------|-------------|-------|
| https     | GET     | /api/users  | oui   |

## Paramètres

per_page : Nombre d'utilisateurs par page (optionnel)

search : Recherche par nom, prénom ou nom d'utilisateur (optionnel)

## Réponses

### Succès

`status: 200`

```json
{
    "data": [
        {
            "id": 1,
            "last_name": "Nom",
            "first_name": "Prénom",
            "user_name": "NomUtilisateur",
            "avatar_url": "url_avatar",
            "admission_year": "année_promotion",
            "created_at": "date_creation",
            "updated_at": "date_mise_à_jour",
            "sector": "secteur",
            "birth_date": "date_naissance"
        },
        {
            "id": 2,
            "last_name": "Nom2",
            "first_name": "Prénom2",
            "user_name": "NomUtilisateur2",
            "avatar_url": "url_avatar2",
            "promotion_year": "année_promotion2",
            "created_at": "date_creation2",
            "updated_at": "date_mise_à_jour2",
            "sector": "secteur2",
            "birth_date": "date_naissance2"
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
```
