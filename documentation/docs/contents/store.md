# Créer un contenu post ou event

Permet la creation d'un contenu post ou event ou alors les deux en même temps. Avec le post qui peut être lié à un event.

## Requête

| protocole | methode | url           | token |
| --------- | ------- |---------------| ----- |
| https     | POST    | /api/contents | oui   |

## Paramètres

| nom             | type    | contraintes             | description          | obligatoire        | quel contenu  |
|-----------------| ------- |-------------------------|----------------------|--------------------|---------------|
| title           | string  | min:3, max:50           | Titre du post        | oui                | post et event |
| body            | string  | min:3, max:4000000000   | Contenu du post      | oui (pour un post) | post et event |
| organization_id | integer | exists:organizations,id | ID de l'organisation | non                | post et event |
| category_id     | integer | exists:cotegories,id    | ID de la category    | oui                | post et event |
| color           | string  | string                  | Couleur du post      | non                | post et event |
| start_at        | date    | date                    | Date de début        | non                | event         |
| end_at          | date    | date                    | Date de fin          | non                | event         |
| location        | string  | string                  | Lieu de l'event      | non                | event         |
| create_event    | boolean | boolean (1 ou 0)        | Créer un event       | non                | event         |
| create_post     | boolean | boolean (1 ou 0)        | Créer un post        | non                | post          |

-  `create_event` et `create_post` ne peuvent pas être tous les deux à `0`
- si `create_event` est à `1` alors `start_at`, `end_at` et `location` sont obligatoires et on obtient la creation d'un event
- si `create_post` est à `1` alors `body` est obligatoires et on obtient la creation d'un post
- si `create_event` et `create_post` sont à `1` alors on obtient la creation d'un event et d'un post lié à l'event

## Réponses

### succès

`status: 201`

```json
{
    "message": "Post created",
    "data": {
        "title": "titre 1",
        "body": "C'est une description",
        "color": "#ffffff",
        "organization_id": "1",
        "user_id": 1,
        "updated_at": "2023-12-27T16:43:39.000000Z",
        "created_at": "2023-12-27T16:43:39.000000Z",
        "id": 24
    }
}
```

```json
{
	"message": "Event created",
	"data": {
		"title": "titre 1",
		"body": "C'est une description",
		"color": "#ffffff",
		"organization_id": "1",
		"user_id": 1,
		"start_at": "2023-12-22",
		"end_at": "2023-12-23",
		"location": "Pôle api",
		"updated_at": "2023-12-27T16:44:27.000000Z",
		"created_at": "2023-12-27T16:44:27.000000Z",
		"id": 13
	}
}
```

```json
{
	"message": "Event and post created",
	"data": {
		"event": {
			"title": "titre 1",
			"body": "C'est une description",
			"color": "#ffffff",
			"organization_id": "1",
			"user_id": 1,
			"start_at": "2023-12-22",
			"end_at": "2023-12-23",
			"location": "Pôle api",
			"updated_at": "2023-12-27T15:35:58.000000Z",
			"created_at": "2023-12-27T15:35:58.000000Z",
			"id": 12
		},
		"post": {
			"title": "titre 1",
			"body": "C'est une description",
			"color": "#ffffff",
			"organization_id": "1",
			"user_id": 1,
			"event_id": 12,
			"updated_at": "2023-12-27T15:35:58.000000Z",
			"created_at": "2023-12-27T15:35:58.000000Z",
			"id": 23
		}
	}
}
```

### erreur

`status: 422`

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "The title field is required."
        ],
        "body": [
            "The body field is required."
        ],
        "category_id": [
            "The category id field is required."
        ]
    }
}
```

`status: 403`

```json
{
    "message": "You are not allowed to create a content for this organization"
}
```

`status: 400`

```json
{
    "message": "Nothing created"
}
```
