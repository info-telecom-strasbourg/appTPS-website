# Déconnexion

Déconnecte un utilisateur de l'application et invalide son token d'authentification.

## Requête

| protocole | methode | url         | token |
| --------- | ------- | ----------- | ----- |
| https     | POST    | /api/logout | oui   |

## Paramètres

Aucun

## Réponse

### Succès

`status: 200`

```json
{
    "message": "Successfully logged out"
}
```

### Erreur

pas d'erreur possible
