# Aquisition des données pour la creation d'un contenue

on peut avoir les categories et les organization disponible pour l'utilisateur

## Requête

| protocole | methode | url                  | token |
| --------- |---------|----------------------| ----- |
| https     | GET     | /api/contents/create | oui   |

## Paramètres

Aucun

## Réponses

### succès

`status: 200`

```json
{
    "data": {
        "oragizations": [
            {
                "id": 1,
                "name": "Lagardesss",
                "role": "président"
            },
            {
                "id": 4,
                "name": "Blot S.A.R.L.",
                "role": "secrétaire"
            }
        ],
        "categories": [
            {
                "id": 2,
                "name": "Activité"
            },
            {
                "id": 3,
                "name": "Poly"
            },
            {
                "id": 1,
                "name": "Soirée"
            }
        ]
    }
}
```
