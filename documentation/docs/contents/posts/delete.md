# Supprimer un post

permet de supprimer un post spécifique par son identifiant.

## Requête

| Protocole | Méthode | URL            | Token |
| --------- | ------- | -------------- | ----- |
| HTTPS     | DELETE  | /api/post/{id} | Oui   |

## Paramètres

Aucun paramètre requis dans le corps de la requête. L'identifiant du post à supprimer est spécifié dans l'URL.

## Réponses

### Succès

`status: 200`

```json
{
    "message": "Post deleted successfully."
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
    "message": "You are not authorized to delete this post."
}
```
