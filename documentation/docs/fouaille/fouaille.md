# fouaille

Renvoie les informations fouaille de l'utilisateur connecté (grace au token).``

## Requête

| protocole | methode | url           | token |
| --------- | ------- | ------------- | ----- |
| https     | GET     | /api/fouaille | oui   |

## Paramètres

Passage de parametre dans l'url pour la pagination
exemple : https://app-pprd.its-tps.fr/api/fouaille?per_page=10&page=2

## Réponse

### Succès

`status: 200`

```json
{
    "data": {
        "balance": "12.71",
        "first_name": "enzo",
        "last_name": "bergamini",
        "user_name": "zozoLeZozo",
        "orders": [
            {
                "date": "2023-06-21 09:56:09",
                "total_price": "5.00",
                "amount": 1,
                "product": null
            },
            {
                "date": "2023-06-20 16:46:15",
                "total_price": "-6.00",
                "amount": 2,
                "product": {
                    "name": "fromage",
                    "title": "fromage",
                    "unit_price": "-3",
                    "color": "#61385c"
                }
            },
            {
                "date": "2023-06-20 07:44:01",
                "total_price": "-4.80",
                "amount": 4,
                "product": {
                    "name": "cocktail12",
                    "title": "cocktail12",
                    "unit_price": "-1.2",
                    "color": "#c2d5ac"
                }
            },
            {
                "date": "2023-06-19 06:02:22",
                "total_price": "-3.60",
                "amount": 3,
                "product": {
                    "name": "cocktail12",
                    "title": "cocktail12",
                    "unit_price": "-1.2",
                    "color": "#c2d5ac"
                }
            },
            {
                "date": "2023-06-16 15:05:50",
                "total_price": "-4.80",
                "amount": 4,
                "product": {
                    "name": "metre",
                    "title": "metre",
                    "unit_price": "-1.2",
                    "color": "#d35b71"
                }
            },
            {
                "date": "2023-06-15 05:55:22",
                "total_price": "-2.40",
                "amount": 2,
                "product": {
                    "name": "metre",
                    "title": "metre",
                    "unit_price": "-1.2",
                    "color": "#d35b71"
                }
            },
            {
                "date": "2023-06-15 03:04:53",
                "total_price": "-6.60",
                "amount": 3,
                "product": {
                    "name": "cookies",
                    "title": "cookies",
                    "unit_price": "-2.2",
                    "color": "#2d3a24"
                }
            },
            {
                "date": "2023-06-14 23:54:57",
                "total_price": "-6.40",
                "amount": 4,
                "product": {
                    "name": "cocktail16",
                    "title": "cocktail16",
                    "unit_price": "-1.6",
                    "color": "#0403ff"
                }
            },
            {
                "date": "2023-06-14 01:53:45",
                "total_price": "-4.80",
                "amount": 3,
                "product": {
                    "name": "cocktail16",
                    "title": "cocktail16",
                    "unit_price": "-1.6",
                    "color": "#0403ff"
                }
            },
            {
                "date": "2023-06-13 04:04:22",
                "total_price": "-6.00",
                "amount": 5,
                "product": {
                    "name": "metre",
                    "title": "metre",
                    "unit_price": "-1.2",
                    "color": "#d35b71"
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
        "next_page_url": "&per_page=10",
        "prev_page_url": "&per_page=10",
        "path": "https://app-pprd.its-tps.fr/api/fouaille",
        "from": 1,
        "to": 10
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
