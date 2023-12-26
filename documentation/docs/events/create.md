# Créer un événement

Creation d'un nouvel événement

## Requête

| protocole | methode | url        | token |
| --------- | ------- | ---------- | ----- |
| https     | POST    | /api/event | oui   |

## Paramètres

| nom             | type     | contraintes  | description                  | obligatoire |
| --------------- | -------- | ------------ | ---------------------------- | ----------- |
| title           | string   | max:255      | Titre de l'événement         | oui         |
| description     | string   | max:10000    | Description de l'événement   | non         |
| start_at        | datetime | date         | Date de début de l'événement | oui         |
| end_at          | datetime | date         | Date de fin de l'événement   | oui         |
| location        | string   | max:255      | Lieu de l'événement          | non         |
| color           | string   | max:7\|min:7 | Couleur de l'événement       | non         |
| organization_id | integer  | exists       | ID de l'organisation         | non         |

## Réponses

### Succès

`status: 201`

```json
{
    "message": "Event created",
    "data": {
        "title": "Event 1",
        "description": "Description event 1",
        "start_at": "2021-03-01 00:00:00",
        "end_at": "2021-03-01 00:00:00",
        "location": "Location event 1",
        "color": "#000000",
        "author": {
            "is_organization": true,
            "id": 1,
            "name": "Organization 1",
            "short_name": "Org 1",
            "logo_url": "http://localhost:8000/storage/organizations/1/logo.png"
        }
    }
}
```

### Erreur

`status: 422`

```json
{
    "message": "Validation failed",
    "errors": {
        "title": ["The title field is required."],
        "start_at": ["The start at field is required."]
    }
}
```
