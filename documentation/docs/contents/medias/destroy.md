# Supprimer un média

Permet de supprimer un média spécifique.

## Requête

| protocole | méthode | url                     | token |
|-----------|---------|-------------------------|-------|
| https     | GET     | /api/media/{id}/destroy | oui   |

## Paramètres

medias_id[] : L'ID du média à supprimer sous forme de tableau.

ex : `medias_id[]=1&medias_id[]=2`

## Réponses

### Succès

`status: 200`

```json
{
    "message": "Media deleted successfully."
}
```

### Erreurs

`status: 404`

```json
{
    "message": "Media not found."
}
```

`status: 403`

```json
{
    "message": "You are not authorized to delete this media."
}
```
