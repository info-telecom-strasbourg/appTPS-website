## Méthode Store - CategoryController

La méthode `store` dans `CategoryController` est utilisée pour créer et associer des catégories à un post ou un événement.

### Description

Cette méthode accepte un `post_id` ou un `event_id` et un tableau de `category_ids`. Elle crée des associations entre le post ou l'événement et les catégories spécifiées. Si les validations échouent ou si aucun `post_id` ou `event_id` n'est fourni, elle renvoie une erreur.

## Requête

| Protocole | Méthode | URL                | Token |
|-----------|---------|--------------------|-------|
| HTTPS     | POST    | /api/categories    | Oui   |

## Paramètres de la requête

Dans le corps de la requête (en tant que `form-data` ou `JSON`):

- `post_id` (facultatif) : L'ID du post auquel associer les catégories.
- `event_id` (facultatif) : L'ID de l'événement auquel associer les catégories.
- `category_ids` (obligatoire) : Un tableau contenant les IDs des catégories à associer.

## Réponse en cas de succès

`Status: 201 Created`

```json
{
    "message": "Catégories associées avec succès.",
    "data": [
        {
            "id": 1,
            "post_id": "1",
            "event_id": null,
            "category_type_id": "2"
        },
        ...
    ]
}
