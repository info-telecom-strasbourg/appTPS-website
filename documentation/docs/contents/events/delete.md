# Supprimer un événement

Permet de supprimer un événement spécifique par son identifiant.

## Requête

| Protocole | Méthode | URL             | Token |
| --------- | ------- | --------------- | ----- |
| HTTPS     | DELETE  | /api/event/{id} | Oui   |

## Paramètres

Aucun paramètre requis dans le corps de la requête. L'identifiant de l'événement à supprimer est spécifié dans l'URL.

## Réponses

### Succès

`status: 200`

```json
{
    "message": "Event deleted successfully."
}
```

### Erreurs

`status: 404`

```json
{
    "message": "Event not found."
}
```

`status: 403`

```json
{
    "message": "You are not authorized to delete this event."
}
```
