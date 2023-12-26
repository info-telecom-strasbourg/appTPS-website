# Mot de passe oublié

Envoie un email de réinitialisation de mot de passe à l'utilisateur.

## Requête

| protocole | methode | url                  | token |
| --------- | ------- | -------------------- | ----- |
| https     | POST    | /api/forgot-password | non   |

## Paramètres

| nom   | type   | contraintes | obligatoire | description            |
| ----- | ------ | ----------- | ----------- | ---------------------- |
| email | string | email       | oui         | Email de l'utilisateur |

## Réponse

### Succès

`status: 200`

```json
{
    "message": "Reset email link send"
}
```

### Erreur

`status: 404`

```json
{
    "message": "Email not found"
}
```
