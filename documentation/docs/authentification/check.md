# Check utilisateur

Vérifie si l'utilisateur est connecté et à valider son email.

## Requête

| protocole | methode | url        | token |
| --------- | ------- | ---------- | ----- |
| https     | POST    | /api/check | oui   |

## Paramètres

Aucun

## Réponse

### Succès

`status: 200`

```json
{
    "message": "You are connected and verified"
}
```

### Erreur
