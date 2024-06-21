# Créer une réaction

Permet la création d'une réaction.

## Requête

| protocole | methode | url                      | token |
| --------- | ------- |--------------------------| ----- |
| https     | POST    | /api/post/{id}/reaction  | oui   |

## Paramètres

| nom              | type    | contraintes             | description              | obligatoire |
|------------------|---------|-------------------------|--------------------------|-------------|
| reaction_type_id | integer | exists:reaction_types,id| ID du type de réaction   | oui         |
| user_id          | integer | exists:users,id         | ID de l'utilisateur      | oui         |
| post_id          | integer | exists:posts,id         | ID du post               | non         |
| post_comment_id  | integer | exists:post_comments,id | ID du commentaire parent | non         |
## Réponses

### succès

`status: 201`

```json
{
    "message": "Réaction créée avec succès !",
    "data": {
        "reaction_type_id": 1,
        "user_id": 1,
        "post_comment_id": 1
    }
}
```

ou :

```json
{
    "message": "Réaction créée avec succès !",
    "data": {
        "reaction_type_id": 1,
        "user_id": 1,
        "post_id": 1
    }
}
```
### erreur

`status: 422`

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "reaction_type_id": [
            "The reaction type id field is required."
        ],
        "user_id": [
            "The user id field is required."
        ],
        "post_id": [
            "The post id field is required."
        ]
    }
}
```

`status: 400`

```json
{
    "message": "Vous avez déjà réagi à ce post."
}
```

