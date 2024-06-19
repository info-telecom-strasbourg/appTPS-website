# Créer un contenu post ou event

Permet la creation d'un contenu post ou event ou alors les deux en même temps. Avec le post qui peut être lié à un event.

## Requête

| protocole | methode | url                    | token |
| --------- | ------- |------------------------| ----- |
| https     | POST    | /api/post/{id}/comment | oui   |

## Paramètres

| nom               | type    | contraintes             | description              | obligatoire        |
|-------------------|---------|-------------------------|--------------------------|--------------------|
| body              | string  | min:3, max:4000000000   | Contenu du commentaire   | oui (pour un post) |
| organization_id   | integer | exists:organizations,id | ID de l'organisation     | non                |
| post_id           | integer | exists:posts,id   | ID du post               | oui                |
| parent_comment_id | integer | exists:post_comments,id                  | ID du commentaire parent | non                |
## Réponses

### succès

`status: 201`

```json
{
    "message": "Commentaire créé avec succès !",
    "data": {
        "body": "C'est une description",
        "organization_id": "1",
        "user_id": 1,
        "post_id": 1,
        "parent_comment_id": 1
    }
}
```

### erreur

`status: 422`

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "body": [
            "The body field is required."
        ],
        "category_id": [
            "The category id field is required."
        ]
    }
}
```
