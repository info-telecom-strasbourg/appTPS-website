# Documentation de la fonction `index` - EventController

## Objectif

Cette fonction est conçue pour récupérer tous les événements du calendrier, en tenant compte de la pagination, de la date de début et de l'identification de l'organisation. Elle permet de filtrer les événements par date et par organisation, et supporte la pagination pour une gestion efficace de l'affichage des données.

## Requête

| Protocole | Méthode | URL                  | Token |
|-----------|---------|----------------------|-------|
| HTTPS     | GET     | /api/events          | Oui   |

## Paramètres de la requête

Les paramètres suivants peuvent être passés dans l'URL :

- `per_page` (optionnel) : Le nombre d'événements à afficher par page. La valeur par défaut est 10.
- `start_at` (optionnel) : La date de début pour filtrer les événements. La valeur par défaut est la date actuelle.
- `organization_id` (optionnel) : L'ID de l'organisation pour filtrer les événements par organisation.
- `previous_date` (optionnel) : Utilisé pour déterminer la date à partir de laquelle filtrer les événements. La valeur par défaut est 10 jours avant la date actuelle.

## Réponse en cas de succès

`Status: 200 OK`

```json
{
    "data": [
        {
            "id": 1,
            "post_id": 1,
            "title": "Titre de l'événement",
            "show_date": "Affichage de la date",
            "date_format": "Format de la date",
            "start_at": "2023-06-21 09:56:09",
            "end_at": "2023-06-21 11:56:09",
            "location": "Lieu de l'événement",
            "color": "#4b6c87",
            "categories": [
                {
                    "name": "Nom de la catégorie"
                }
            ],
            "created_at": "2023-06-20 09:56:09",
            "updated_at": "2023-06-20 10:56:09",
            "author": {
                "is_organization": true,
                "id": 1,
                "name": "Nom de l'organisation",
                "short_name": "Nom court",
                "user_name": "Nom d'utilisateur",
                "logo_url": "URL du logo"
            }
        }
    ],
    "meta": {
        "total": 100,
        "per_page": 10,
        "current_page": 1,
        "last_page": 10,
        "first_page_url": "https://app-pprd.its-tps.fr/api/events?page=1&per_page=10",
        "last_page_url": "https://app-pprd.its-tps.fr/api/events?page=10&per_page=10",
        "next_page_url": "https://app-pprd.its-tps.fr/api/events?page=2&per_page=10",
        "prev_page_url": null,
        "path": "https://app-pprd.its-tps.fr/api/events",
        "from": 1,
        "to": 10
    }
}
```
