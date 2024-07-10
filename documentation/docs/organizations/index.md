## Méthode Index - OrganizationController

La méthode `index` dans `OrganizationController` est utilisée pour récupérer et renvoyer une liste d'organisations.

### Description

Cette méthode récupère toutes les organisations, les transforme en un format spécifique, puis renvoie ces données sous forme de réponse JSON.

## Requête

| protocole | methode | url               | token |
| --------- | ------- |-------------------| ----- |
| https     | GET     | /api/organization | oui   |

## Paramètres

aucuns

### Réponse

La réponse est un objet JSON qui contient une propriété principale : `data`. Cette propriété est un objet qui contient deux propriétés : `associations` et `clubs`. Chaque propriété est un tableau d'objets, où chaque objet représente une organisation.

Chaque objet d'organisation contient les propriétés suivantes :

- `id` : L'ID de l'organisation.
- `short_name` : Le nom court de l'organisation.
- `name` : Le nom complet de l'organisation.
- `logo_url` : L'URL du logo de l'organisation.

### Exemple de réponse

```json
{
    "data": {
        "associations": [
            {
                "id": 1,
                "short_name": "asso1",
                "user_name": "Association-1",
                "name": "Association 1",
                "logo_url": "http://example.com/logo1.png"
            }
        ],
        "clubs": [
            {
                "id": 2,
                "short_name": "club1",
                "user_name": "Association-1",
                "name": "Club 1",
                "logo_url": "http://example.com/logo2.png"
            }
        ]
    }
}
```
