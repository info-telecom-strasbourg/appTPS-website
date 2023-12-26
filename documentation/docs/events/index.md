# Liste les événements

Liste des événements paginés

## Requête

| protocole | methode | url        | token |
| --------- | ------- | ---------- | ----- |
| https     | GET     | /api/event | oui   |

## Paramètres

-   **page** et **per_page** paramètres de pagination a passer dans l'url exemple : /api/event?per_page=10&page=1

-   **start_at** et **end_at** paramètres de filtre de date a passer dans l'url exemple : /api/event?start_at=2021-03-01&end_at=2021-03-02

## Réponses

### Succès

`status: 200`

```json
{
    "data": [
        {
            "title": "Facere reprehenderit ullam modi.",
            "description": "Et aliquam et officiis facere cupiditate in. Error vero explicabo ea amet. Et qui quam ea doloremque error tempora. Blanditiis et consectetur a consequuntur. Voluptatem sit beatae officia voluptatem adipisci.",
            "start_at": "2023-08-07 16:39:00",
            "end_at": "2023-08-08 07:09:45",
            "location": "67028 Christian Divide\nSchroederview, DC 73702",
            "color": "#4b6c87",
            "author": {
                "is_organization": false,
                "id": 8,
                "name": "Karianne Sauer",
                "short_name": null,
                "logo_url": "https://app-pprd.its-tps.fr/storage/images/avatars/default.png"
            }
        },
        {
            "title": "Unde accusantium occaecati velit eius maiores non fugiat optio.",
            "description": "Aliquid sapiente ipsam id adipisci consequatur qui maiores. Maxime repellat molestias et quo ut et aperiam ut. Dolore vero facilis et ipsum enim.",
            "start_at": "2023-08-07 10:28:00",
            "end_at": "2023-08-07 11:22:30",
            "location": "9528 Nicolas Branch Apt. 332\nHuelsbury, NV 41670",
            "color": "#6b3fe7",
            "author": {
                "is_organization": true,
                "id": 6,
                "name": "Mathieu",
                "short_name": "occaecati",
                "logo_url": "https://fouaille.its-tps.fr/storage/organizations//tmp/183997ba4f51116a762bd6e68fe18818.png"
            }
        },
        {
            "title": "Temporibus modi eligendi numquam veniam maxime aut accusantium inventore.",
            "description": "Error autem doloremque quidem sunt est placeat harum. Quis quia aliquam nihil doloribus voluptas voluptatem. Quisquam qui repellendus exercitationem quia tempore id ipsum. Perspiciatis corporis tenetur natus cumque.",
            "start_at": "2023-08-06 18:03:01",
            "end_at": "2023-08-07 02:06:24",
            "location": "3392 Ritchie Island Apt. 070\nLegroschester, ME 60627-7890",
            "color": "#1431a2",
            "author": {
                "is_organization": false,
                "id": 3,
                "name": "Alvis Hammes",
                "short_name": null,
                "logo_url": "https://app-pprd.its-tps.fr/storage/images/avatars/default.png"
            }
        }
    ],
    "meta": {
        "total": 10,
        "per_page": 3,
        "current_page": 1,
        "last_page": 4,
        "first_page_url": "https://app-pprd.its-tps.fr/api/event?page=1&per_page=3",
        "last_page_url": "https://app-pprd.its-tps.fr/api/event?page=4&per_page=3",
        "next_page_url": "https://app-pprd.its-tps.fr/api/event?page=2&per_page=3",
        "prev_page_url": "&per_page=3",
        "path": "https://app-pprd.its-tps.fr/api/event",
        "from": 1,
        "to": 3
    }
}
```

##### Erreur

`status: 401`

```json
{
    "message": "Unauthenticated."
}
```
