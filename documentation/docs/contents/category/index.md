## Méthode Index - CategoryController

La méthode `index` dans `CategoryTypeController` est utilisée pour récupérer et renvoyer une liste de catégories.

### Description

Cette méthode récupère toutes les catégories, les transforme en un format spécifique, puis renvoie ces données sous forme de réponse JSON.

## Requête

| protocole | methode | url             | token |
| --------- | ------- |-----------------| ----- |
| https     | GET     | /api/categories | oui   |

## Paramètres

aucuns

### Réponse

La réponse est un objet JSON qui contient une propriété principale : `data`. Cette propriété est un tableau d'objets, où chaque objet représente une catégorie.

Chaque objet de catégorie contient les propriétés suivantes :

- `id` : L'ID de la catégorie.
- `name` : Le nom de la catégorie.
- `color` : La description de la catégorie.
- `is_shown` : La description de la catégorie.
- `is_for_event` : La description de la catégorie.

### Exemple de réponse

```json
{
    "data": [
        {
            "id": 1,
            "name": "Category 1",
            "color": "#000000",
            "emoji": "🎉",
            "is_shown": true,
            "is_for_event": true
        },
        ...
    ]
}
