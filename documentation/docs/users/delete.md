# Delete user

Supprime l'utilisateur connecté (grace au token).

## Requête

| protocole | methode | url       | token |
| --------- | ------- | --------- | ----- |
| https     | DELETE  | /api/user | oui   |

## Réponse

### Succès

`status: 200`

```json
{
    "message": "The user has been deleted"
}
```

### Erreur

`status: 401`

```json
{
    "message": "Unauthenticated."
}
```
