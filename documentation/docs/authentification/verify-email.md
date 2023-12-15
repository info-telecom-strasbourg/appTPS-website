# Envoie de mail de vérification

Envoie un email de vérification à l'utilisateur.

## Requête

| protocole | methode | url                                  | token |
| --------- | ------- | ------------------------------------ | ----- |
| https     | POST    | /api/email/verification-notification | oui   |

## Paramètres

Aucun

## Réponse

### Succès

`status: 200`

```json
{
    "message": "Verification link sent"
}
```

### Erreur

`status: 400`

```json
{
    "message": "Email is already verified"
}
```
