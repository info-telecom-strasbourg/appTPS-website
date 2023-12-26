# Update user

Met à jour l'avater de l'utilisateur connecté (grace au token).

## Requête

| protocole | methode | url              | token |
| --------- | ------- | ---------------- | ----- |
| https     | PUT     | /api/user/avatar | oui   |

## Paramètres

| nom    | type | contraintes                       | obligatoire | description             |
| ------ | ---- | --------------------------------- | ----------- | ----------------------- |
| avatar | file | image mimes:jpeg,png,jpg max:2048 | oui         | Avatar de l'utilisateur |

## Réponse

### Succès

`status: 200`

```json
{
    "message": "Avatar uploaded successfully"
}
```

### Erreur

`status: 401`

```json
{
    "message": "Unauthenticated."
}
```

`status: 422`

```json
{
    "message": "Validation failed",
    "errors": {
        "avatar": ["The avatar must be a file of type: jpeg, png, jpg."]
    }
}
```
