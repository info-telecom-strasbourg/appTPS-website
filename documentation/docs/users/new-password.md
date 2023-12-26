# Nouveau mot de passe

Met à jour le mot de passe de l'utilisateur connecté (grace au token).

## Requête

| protocole | methode | url           | token |
| --------- | ------- | ------------- | ----- |
| https     | PUT     | /api/password | oui   |

## Paramètres

| nom                   | type   | contraintes        | obligatoire | description                           |
| --------------------- | ------ | ------------------ | ----------- | ------------------------------------- |
| formerPassword        | string | Gérer par le front | oui         | Ancien mot de passe de l'utilisateur  |
| password              | string | Gérer par le front | oui         | Nouveau mot de passe de l'utilisateur |
| password_confirmation | string | Gérer par le front | oui         | Confirmation du nouveau mot de passe  |

## Réponse

### Succès

`status: 200`

```json
{
    "message": "Password updated successfully."
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
    "message": "The password does not match"
}
```
