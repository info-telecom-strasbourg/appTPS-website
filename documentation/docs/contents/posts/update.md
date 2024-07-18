# Mettre à jour un post

Cette API permet de mettre à jour un post spécifique par son identifiant.

## Requête

| Protocole | Méthode | URL                    | Token |
|-----------|---------|------------------------|-------|
| HTTPS     | GET     | /api/posts/{id}/update | Oui   |

## Paramètres du corps de la requête

```json
{
    "body": "Le nouveau contenu du post.",
    "category_ids": [1, 2, 3]
}
```

- body : Le contenu du post.
- category_id : Les identifiants de la catégorie du post sous forme de tableau.

## Réponses

### Succès

`status: 200`

```json
{
    "message": "Post updated successfully.",
    "data": {
        // le contenu du nouveau post
    }
}
```

### Erreurs

`status: 404`

```json
{
    "message": "Post not found."
}
```

`status: 403`

```json
{
    "message": "You are not authorized to update this post."
}
```
