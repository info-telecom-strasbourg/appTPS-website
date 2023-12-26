# Vérification de la disponibilité des données d'authentification

## Requête

| protocole | methode | url                        | token |
| --------- | ------- | -------------------------- | ----- |
| https     | GET     | /api/register/availability | non   |

## Paramètres

-   **email** email de l'utilisateur dans l'url exemple : /api/register/availability?email=**email**
-   **username** username de l'utilisateur dans l'url exemple : /api/register/availability?username=**username**
-   **phone** phone de l'utilisateur dans l'url exemple : /api/register/availability?phone=**phone**

## Réponses

### Succès

`status: 200`

```json
{
    "message": "This value is available"
}
```

### Erreur

`status: 409`

```json
{
    "message": "An other user already exist with this value"
}
```
