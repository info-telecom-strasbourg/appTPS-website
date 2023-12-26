# Liste les filières disponibles

Permet d'afficher les filière disponible

## Requête

| protocole | methode | url         | token |
| --------- | ------- | ----------- | ----- |
| https     | GET     | /api/sector | non   |

## Réponses

### Succès

`status : 200`

```json
{
    "data": [
        {
            "id": 1,
            "name": "Informatique",
            "short_name": "INFO"
        },
        {
            "id": 2,
            "name": "Génie Civil",
            "short_name": "GC"
        },
        {
            "id": 3,
            "name": "Génie Electrique",
            "short_name": "GE"
        },
        {
            "id": 4,
            "name": "Génie Mécanique",
            "short_name": "GM"
        },
        {
            "id": 5,
            "name": "Génie Industriel",
            "short_name": "GI"
        },
        {
            "id": 6,
            "name": "Génie des Procédés",
            "short_name": "GP"
        },
        {
            "id": 7,
            "name": "Génie des Télécommunications",
            "short_name": "GT"
        },
        {
            "id": 8,
            "name": "Génie des Matériaux",
            "short_name": "GM"
        },
        {
            "id": 9,
            "name": "Génie des Energies Renouvelables",
            "short_name": "GER"
        }
    ]
}
```
