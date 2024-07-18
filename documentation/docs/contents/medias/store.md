# Créer un média

Permet la création d'un média.

## Requête

| protocole | méthode | url                  | token |
|-----------|---------|----------------------|-------|
| https     | POST    | /api/post/{id}/media | oui   |

## Paramètres

| nom      | type     | contraintes            | description                | obligatoire |
|----------|----------|------------------------|----------------------------|-------------|
| `medias` | file_tab | max:5000               | Fichier du média           | oui         |

Formats acceptés : image/jpeg,image/png,video/mp4,video/x-msvideo,video/quicktime

exemple : 

```json
{
    "medias": [
        "image": "image.jpg",
        "video": "video.mp4"
    ]
}
```

## Réponses

### Succès

`status: 201`

```json
{
    "message": "Image/video uploaded successfully !",

}
```

### Erreur

`status: 422`

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "media": [
            "The media field is required."
        ]
    }
}
```
