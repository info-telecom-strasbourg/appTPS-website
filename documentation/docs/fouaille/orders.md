# Documentation de la fonction `show` - FouailleController

## Objectif

Cette fonction est conçue pour afficher les commandes fouaille d'un utilisateur spécifique, en incluant des informations détaillées sur chaque commande ainsi que le solde actuel de l'utilisateur. Elle supporte la pagination pour gérer efficacement l'affichage des données.

## Requête

| Protocole | Méthode | URL                      | Token |
|-----------|---------|--------------------------|-------|
| HTTPS     | GET     | /api/fouaille            | Oui   |

## Paramètres de la requête

Les paramètres suivants peuvent être passés dans l'URL pour la pagination :

- `per_page` (optionnel) : Le nombre de commandes à afficher par page. La valeur par défaut est 10.
- `page` (optionnel) : Le numéro de la page à afficher.

## Réponse en cas de succès

`Status: 200 OK`

```json
{
    "data": {
        "orders": [
            {
                "date": "2023-06-21 09:56:09",
                "date_format": "21/06/2023",
                "actual_balance": "12.71",
                "total_price": "5.00",
                "amount": 1,
                "product": null
            },
            {
                "date": "2023-06-20 16:46:15",
                "date_format": "20/06/2023",
                "actual_balance": "7.71",
                "total_price": "-6.00",
                "amount": 2,
                "product": {
                    "name": "fromage",
                    "type": "soiree",
                    "unit_price": "-3.00"
                }
            }
        ]
    },
    "meta": {
        "total": 10,
        "per_page": 10,
        "current_page": 1,
        "last_page": 1,
        "first_page_url": "https://app-pprd.its-tps.fr/api/fouaille?page=1&per_page=10",
        "last_page_url": "https://app-pprd.its-tps.fr/api/fouaille?page=1&per_page=10",
        "next_page_url": null,
        "prev_page_url": null,
        "path": "https://app-pprd.its-tps.fr/api/fouaille",
        "from": 1,
        "to": 10
    }
}
```
