# Documentation de la fonction `balance` - FouailleController

## Objectif

Cette fonction est conçue pour récupérer le solde actuel d'un utilisateur spécifique. Elle calcule le total des transactions (dépenses et revenus) pour fournir le solde net.

## Requête

| Protocole | Méthode | URL                   | Token |
| --------- | ------- | --------------------- | ----- |
| HTTPS     | GET     | /api/fouaille/balance | Oui   |

## Paramètres de la requête

Aucun paramètre n'est requis pour cette requête. L'identification de l'utilisateur est réalisée via le token d'authentification fourni.

## Réponse en cas de succès

`Status: 200 OK`

```json
{
    "data": {
        "balance": "100.00",
        "first_name": "Thibaut",
        "last_name": "$DESLANDES",
        "user_name": "$tb_des"
    }
}
```
