# Authentification 

## Registration

### Register

Créer un nouvel utilisateur dans la base de données de l'application et dans la base de données du BDE et envoie un mail de confirmation à l'utilisateur.

| protocole | methode | url           | token |
|-----------|---------|---------------|-------|
| https     | POST    | /api/register | no    |

#### Paramètres

| nom       | type | contraintes                         | obligatoire | description                     |
|-----------|------|-------------------------------------|-------------|---------------------------------|
| user_name | string | min:3, max:30, unique               | non         | Nom de l'utilisateur            |
| last_name | string | min:3, max:255                      | oui         | Nom de famille de l'utilisateur |
| first_name | string | min:3, max:255                      | oui         | Prénom de l'utilisateur         |
| sector | integer | exists                              | oui         | Filiére de l'utilisateur        |
| email | string | email, max:255, unique              | oui         | Email de l'utilisateur          |
| phone | string | min:3, max:10, unique               | non         | Numéro de téléphone de l'utilisateur |
| promotion_year | integer | min:2000, max:3000                  | non         | Année de promotion de l'utilisateur |
| password | string | min:8, uppercase, lowercase, number | oui         | Mot de passe de l'utilisateur   |
| password_confirmation | string | min:8, uppercase, lowercase, number | oui         | Confirmation du mot de passe de l'utilisateur   |

#### Réponse

##### Succès
    
- Code : **201**
- Contenu :
```json
{
    "user": {
        "id": 1,
        "user_name": "user_name",
        "last_name": "last_name",
        "first_name": "first_name",
        "sector": 1,
        "email": "email",
        "phone": "phone",
        "promotion_year": 2020,
        "created_at": "2020-12-12T00:00:00.000000Z",
        "updated_at": "2020-12-12T00:00:00.000000Z",
    },
    "token": "token"
}
```

##### Erreur

- Code : **422**
- Contenu :
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email has already been taken."
        ],
        "user_name": [
            "The user name has already been taken."
        ]
    }
}
```

### Login

Connecte un utilisateur à l'application et renvoie un token d'authentification.


| protocole | methode | url           | token |
|-----------|---------|---------------|-------|
| https     | POST    | /api/login    | no    |

#### Paramètres

| nom       | type | contraintes                         | obligatoire | description                     |
|-----------|------|-------------------------------------|-------------|---------------------------------|
| email | string | email, max:255, exists              | oui         | Email de l'utilisateur          |
| password | string | min:8, uppercase, lowercase, number | oui         | Mot de passe de l'utilisateur   |

#### Réponse

##### Succès

- Code : **200**
- Contenu : 
```json
{
    "user": {
        "id": 1,
        "user_name": "user_name",
        "last_name": "last_name",
        "first_name": "first_name",
        "sector": 1,
        "email": "email",
        "phone": "phone",
        "promotion_year": 2020,
        "created_at": "2020-12-12T00:00:00.000000Z",
        "updated_at": "2020-12-12T00:00:00.000000Z",
    },
    "token": "token"
}
```

##### Erreur

- Code : **401**
- Contenu :
```json
{
    "message": [
        "mauvais identifiants"
    ]
}
```

### Logout

Déconnecte un utilisateur de l'application. (retirer sont token)

| protocole | methode | url           | token |
|-----------|---------|---------------|-------|
| https     | POST    | /api/logout   | oui   |

#### Paramètres

Aucun

#### Réponse

##### Succès

- Code : **200**
- Contenu : 
```json
{
    "message": "Successfully logged out"
}
```

##### Erreur

pas d'erreur possible

## Email verification

### Send verification email

| protocole | methode | url           | token |
|-----------|---------|---------------|-------|
| https     | POST    | /api/verification-notification | oui   |

#### Paramètres

Aucun

#### Réponse

##### Succès

- Code : **200**
- Contenu : 
```json
{
    "message": "Verification link sent"
}
```

##### Erreur

- Code : **400**
- Contenu :
```json
{
    "message": "Email is already verified"
}
```

### vérification de l'email

Gestion de cette route par l'email de vérification, met l'utilisateur en vérifié.

| protocole | methode | url                           | token  |
|-----------|---------|-------------------------------|--------|
| https     | GET    | /api/verify-email/{id}/{hash} | non    |

#### Paramètres

- id : id de l'utilisateur
- hash : hash de l'utilisateur (généré par l'app)

#### Réponse

##### Succès

- redirection vers une page web de succès

##### Erreur

- pas de gestion d'erreur

## Password 

### Send password reset email

Envoie un email de réinitialisation de mot de passe à l'utilisateur.

| protocole | methode | url           | token |
|-----------|---------|---------------|-------|
| https     | POST    | /api/forgot-password | non   |

#### Paramètres

| nom       | type | contraintes       | obligatoire | description                     |
|-----------|------|-------------------|-------------|---------------------------------|
| email | string | email             | oui         | Email de l'utilisateur          |

#### Réponse

##### Succès

- Code : **200**
- Contenu : 
```json
{
    "message": "Reset email link send"
}
```

##### Erreur

- Code : **404**
- Contenu :
```json
{
    "message": "Email not send"
}
```

### Update password

met à jour le mot de passe de l'utilisateur.

| protocole | methode | url           | token |
|-----------|---------|---------------|-------|
| https     | PUT     | /api/password | oui   |

#### Paramètres

| nom       | type | contraintes       | obligatoire | description                     |
|-----------|------|-------------------|-------------|---------------------------------|
| former_password | string | min:8, uppercase, lowercase, number | oui         | Ancien mot de passe de l'utilisateur          |
| password | string | min:8, uppercase, lowercase, number | oui         | Nouveau mot de passe de l'utilisateur          |
| password_confirmation | string | min:8, uppercase, lowercase, number | oui         | Confirmation du nouveau mot de passe de l'utilisateur          |

#### Réponse

##### Succès

- Code : **200**
- Contenu : 
```json
{
    "message": "Password updated successfully"
}
```

##### Erreur

- Code : **422**
- Contenu :
```json
{
    "message": "the password does not match"
}
```

## User

### Get user

Renvoie les informations de l'utilisateur connecté (grace au token).

| protocole | methode | url          | token |
|-----------|---------|--------------|-------|
| https     | GET     | /api/user/me | oui   |

#### Paramètres

Aucun

#### Réponse

##### Succès

- Code : **200**
- Contenu : 
```json
{
    "data": {
            "id": 1,
            "last_name": "bergamini",
            "first_name": "enzo",
            "user_name": "zozoLeZozo",
            "email": "bergaminienzo62@gmail.com",
            "phone": "0606060606",
            "bde_id": 1,
            "avatar_url": "https://app-pprd.its-tps.fr/storage/images/avatars/default.png",
            "promotion_year": "2024",
            "created_at": "2023-08-06T15:35:05.000000Z",
            "updated_at": "2023-08-06T15:35:05.000000Z",
            "email_verified_at": "2023-08-06T15:35:05.000000Z",
            "sector": "AUTRE"
        }
}
```

##### Erreur

- Code : **401**
- Contenu :
```json
{
    "message": "Unauthenticated."
}
```

### Update user

Met à jour les informations de l'utilisateur connecté (grace au token).

| protocole | methode | url       | token |
|-----------|---------|-----------|-------|
| https     | PUT     | /api/user | oui   |

#### Paramètres

| nom             | type   | contraintes       | obligatoire | description                     |
|-----------------|--------|-------------------|-------------|---------------------------------|
| user_name       | string | min:3, max:255    | non         | Nom d'utilisateur de l'utilisateur |
| phone           | string | max:255, regex:/^[0-9]{10,}$/ | non         | Numéro de téléphone de l'utilisateur |
| sector          | integer|                   | non         | Identifiant du secteur de l'utilisateur |
| promotion_year  | string |                   | non         | Année de promotion de l'utilisateur |
| avatar          | image  | mimes:jpeg,png,jpg|max:2048 | non         | Avatar de l'utilisateur |

#### Réponse

##### Succès

- Code : **200**
- Contenu : 
```json
{
    "message": "User updated successfully",
    "data": {
        "id": 1,
        "last_name": "bergamini",
        "first_name": "enzo",
        "user_name": "zozoLeZozo",
        "email": "bergaminienzo62@gmail.com",
        "phone": "0606060606",
        "bde_id": 1,
        "avatar_url": "https://app-pprd.its-tps.fr/storage/images/avatars/default.png",
        "promotion_year": "2024",
        "created_at": "2023-08-06T15:35:05.000000Z",
        "updated_at": "2023-08-06T15:35:05.000000Z",
        "email_verified_at": "2023-08-06T15:35:05.000000Z",
        "sector": "AUTRE"
    }
}
```

##### Erreur

- Code : **401**
- Contenu :
```json
{
    "message": "Unauthenticated."
}
```

- Code : **422**
- Contenu :
```json
{
    "message": "Validation failed",
    "errors": {
        "user_name": [
            "The user name must be at least 3 characters."
        ],
        "phone": [
            "The phone format is invalid."
        ],
        "sector": [
            "The sector must be an integer."
        ],
        "promotion_year": [
            "The promotion year must be a string."
        ],
        "avatar": [
            "The avatar must be an image."
        ]
    }
}
```

### Delete user

Supprime l'utilisateur connecté (grace au token).

| protocole | methode | url       | token |
|-----------|---------|-----------|-------|
| https     | DELETE  | /api/user | oui   |

#### Réponse

##### Succès

- Code : **200**
- Contenu : 
```json
{
    "message": "The user has been deleted"
}
```

##### Erreur

- Code : **401**
- Contenu :
```json
{
    "message": "Unauthenticated."
}
```

## fouaille

### show fouaille

Renvoie les informations fouaille de l'utilisateur connecté (grace au token).

| protocole | methode | url          | token |
|-----------|---------|--------------|-------|
| https     | GET     | /api/fouaille | oui   |

#### Paramètres

Passage de parametre dans l'url pour la pagination
exemple : https://app-pprd.its-tps.fr/api/fouaille?per_page=10&page=2

#### Réponse

##### Succès

- Code : **200**
- Contenu : 
```json
{
    "data": {
        "balance": "12.71",
        "first_name": "enzo",
        "last_name": "bergamini",
        "user_name": "zozoLeZozo",
        "orders": [
            {
                "date": "2023-06-21 09:56:09",
                "total_price": "5.00",
                "amount": 1,
                "product": null
            },
            {
                "date": "2023-06-20 16:46:15",
                "total_price": "-6.00",
                "amount": 2,
                "product": {
                    "name": "fromage",
                    "title": "fromage",
                    "unit_price": "-3",
                    "color": "#61385c"
                }
            },
            {
                "date": "2023-06-20 07:44:01",
                "total_price": "-4.80",
                "amount": 4,
                "product": {
                    "name": "cocktail12",
                    "title": "cocktail12",
                    "unit_price": "-1.2",
                    "color": "#c2d5ac"
                }
            },
            {
                "date": "2023-06-19 06:02:22",
                "total_price": "-3.60",
                "amount": 3,
                "product": {
                    "name": "cocktail12",
                    "title": "cocktail12",
                    "unit_price": "-1.2",
                    "color": "#c2d5ac"
                }
            },
            {
                "date": "2023-06-16 15:05:50",
                "total_price": "-4.80",
                "amount": 4,
                "product": {
                    "name": "metre",
                    "title": "metre",
                    "unit_price": "-1.2",
                    "color": "#d35b71"
                }
            },
            {
                "date": "2023-06-15 05:55:22",
                "total_price": "-2.40",
                "amount": 2,
                "product": {
                    "name": "metre",
                    "title": "metre",
                    "unit_price": "-1.2",
                    "color": "#d35b71"
                }
            },
            {
                "date": "2023-06-15 03:04:53",
                "total_price": "-6.60",
                "amount": 3,
                "product": {
                    "name": "cookies",
                    "title": "cookies",
                    "unit_price": "-2.2",
                    "color": "#2d3a24"
                }
            },
            {
                "date": "2023-06-14 23:54:57",
                "total_price": "-6.40",
                "amount": 4,
                "product": {
                    "name": "cocktail16",
                    "title": "cocktail16",
                    "unit_price": "-1.6",
                    "color": "#0403ff"
                }
            },
            {
                "date": "2023-06-14 01:53:45",
                "total_price": "-4.80",
                "amount": 3,
                "product": {
                    "name": "cocktail16",
                    "title": "cocktail16",
                    "unit_price": "-1.6",
                    "color": "#0403ff"
                }
            },
            {
                "date": "2023-06-13 04:04:22",
                "total_price": "-6.00",
                "amount": 5,
                "product": {
                    "name": "metre",
                    "title": "metre",
                    "unit_price": "-1.2",
                    "color": "#d35b71"
                }
            }
        ]
    },
    "meta": {
        "total": 10,
        "per_page": 10,
        "current_page": 1,
        "last_page": 1,
        "first_page_url": "https://app-pprd.its-tps.fr/api/fouaille?page=1&per_page=10",
        "last_page_url": "https://app-pprd.its-tps.fr/api/fouaille?page=1&per_page=10",
        "next_page_url": "&per_page=10",
        "prev_page_url": "&per_page=10",
        "path": "https://app-pprd.its-tps.fr/api/fouaille",
        "from": 1,
        "to": 10
    }
}
```

##### Erreur

- Code : **401**
- Contenu :
```json
{
    "message": "Unauthenticated."
}
```

## Event

### Créer un événement

Creation d'un nouvel événement

| protocole | methode | url        | token |
|-----------|---------|------------|-------|
| https     | POST    | /api/event | oui   |

#### Paramètres


| nom            | type     | contraintes | description | obligatoire |
|----------------|----------|------------|-------------|-------------|
| title          | string   | max:255    | Titre de l'événement | oui |
| description    | string   | max:10000  | Description de l'événement | non |
| start_at       | datetime | date       | Date de début de l'événement | oui |
| end_at         | datetime | date       | Date de fin de l'événement | oui |
| location       | string   | max:255    | Lieu de l'événement | non |
| color          | string   | max:7\|min:7| Couleur de l'événement | non |
| organization_id| integer  | exists | ID de l'organisation | non |

#### Réponses

- Code : **201**
- Contenu :
```json
{
    "message": "Event created",
    "data": {
        "title": "Event 1",
        "description": "Description event 1",
        "start_at": "2021-03-01 00:00:00",
        "end_at": "2021-03-01 00:00:00",
        "location": "Location event 1",
        "color": "#000000",
        "author": {
            "is_organization": true,
            "id": 1,
            "name": "Organization 1",
            "short_name": "Org 1",
            "logo_url": "http://localhost:8000/storage/organizations/1/logo.png"
        }
    }
}
```

##### Erreur

- Code : **422**
- Contenu :
```json
{
    "message": "Validation failed",
    "errors": {
        "title": [
            "The title field is required."
        ],
        "start_at": [
            "The start at field is required."
        ]
    }
}
```

### Lister les événements

Liste des événements paginés

| protocole | methode | url        | token |
|-----------|---------|------------|-------|
| https     | GET     | /api/event | oui   |

#### Paramètres
 
paramètres de pagination a passer dans l'url exemple : /api/event?per_page=10&page=1

#### Réponses

##### Succès

- Code : **200**
- Contenue : 
```json
{
    "data": [
        {
            "title": "Facere reprehenderit ullam modi.",
            "description": "Et aliquam et officiis facere cupiditate in. Error vero explicabo ea amet. Et qui quam ea doloremque error tempora. Blanditiis et consectetur a consequuntur. Voluptatem sit beatae officia voluptatem adipisci.",
            "start_at": "2023-08-07 16:39:00",
            "end_at": "2023-08-08 07:09:45",
            "location": "67028 Christian Divide\nSchroederview, DC 73702",
            "color": "#4b6c87",
            "author": {
                "is_organization": false,
                "id": 8,
                "name": "Karianne Sauer",
                "short_name": null,
                "logo_url": "https://app-pprd.its-tps.fr/storage/images/avatars/default.png"
            }
        },
        {
            "title": "Unde accusantium occaecati velit eius maiores non fugiat optio.",
            "description": "Aliquid sapiente ipsam id adipisci consequatur qui maiores. Maxime repellat molestias et quo ut et aperiam ut. Dolore vero facilis et ipsum enim.",
            "start_at": "2023-08-07 10:28:00",
            "end_at": "2023-08-07 11:22:30",
            "location": "9528 Nicolas Branch Apt. 332\nHuelsbury, NV 41670",
            "color": "#6b3fe7",
            "author": {
                "is_organization": true,
                "id": 6,
                "name": "Mathieu",
                "short_name": "occaecati",
                "logo_url": "https://fouaille.its-tps.fr/storage/organizations//tmp/183997ba4f51116a762bd6e68fe18818.png"
            }
        },
        {
            "title": "Temporibus modi eligendi numquam veniam maxime aut accusantium inventore.",
            "description": "Error autem doloremque quidem sunt est placeat harum. Quis quia aliquam nihil doloribus voluptas voluptatem. Quisquam qui repellendus exercitationem quia tempore id ipsum. Perspiciatis corporis tenetur natus cumque.",
            "start_at": "2023-08-06 18:03:01",
            "end_at": "2023-08-07 02:06:24",
            "location": "3392 Ritchie Island Apt. 070\nLegroschester, ME 60627-7890",
            "color": "#1431a2",
            "author": {
                "is_organization": false,
                "id": 3,
                "name": "Alvis Hammes",
                "short_name": null,
                "logo_url": "https://app-pprd.its-tps.fr/storage/images/avatars/default.png"
            }
        }
    ],
    "meta": {
        "total": 10,
        "per_page": 3,
        "current_page": 1,
        "last_page": 4,
        "first_page_url": "https://app-pprd.its-tps.fr/api/event?page=1&per_page=3",
        "last_page_url": "https://app-pprd.its-tps.fr/api/event?page=4&per_page=3",
        "next_page_url": "https://app-pprd.its-tps.fr/api/event?page=2&per_page=3",
        "prev_page_url": "&per_page=3",
        "path": "https://app-pprd.its-tps.fr/api/event",
        "from": 1,
        "to": 3
    }
}
```

##### Erreur

- Code : **401**
- Contenu :
```json
{
    "message": "Unauthenticated."
}
```

### Afficher un événement

Affiche un événement en fonction de son ID

| protocole | methode | url              | token |
|-----------|---------|------------------|-------|
| https     | GET     | /api/event/{id}  | oui   |

#### Paramètres

- **id** : ID de l'événement

#### Réponses

##### Succès

- Code : **200**
- Contenu :
```json
{
    "data": {
        "title": "Consequatur dolor molestias rerum non et repellat nisi.",
        "description": "Consequatur laudantium ipsa et aliquam vitae vitae tempore. Animi dolore eum ut atque quo consectetur. Dolore corporis qui at facere. Minus accusamus rerum qui vero et.",
        "start_at": "2023-08-06 11:33:19",
        "end_at": "2023-08-06 11:36:42",
        "location": "5413 Brown Village Apt. 865\nNew Mariamstad, FL 16176-6230",
        "color": "#bc8a01",
        "author": {
            "is_organization": false,
            "id": 1,
            "name": "enzo bergamini",
            "short_name": null,
            "logo_url": "https://app-pprd.its-tps.fr/storage/images/avatars/default.png"
        }
    }
}
```

##### Erreur

- Code : **401**
- Contenu :
```json
{
    "message": "Unauthenticated."
}
```

- Code : **404**
- Contenu :
```json
{
    "message": "Event not found"
}
```

## Post 

### Créer un post

Créer un post

| protocole | methode | url        | token |
|-----------|---------|------------|-------|
| https     | POST    | /api/post  | oui   |

#### Paramètres

| nom            | type     | contraintes | description                       | obligatoire |
|----------------|----------|------------|-----------------------------------|-------------|
| title          | string   | min:3, max:50 | Titre du post                     | oui |
| body           | string   | min:3, max:4000000000 | Contenu du post                   | oui |
| organization_id| integer  | exists:organizations,id | ID de l'organisation              | non |
| event_id       | integer  | exists:events,id | ID de l'événement rataché au post | non |
| color          | string   | regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i | Couleur du post | non |

#### Réponses

##### succès

- Code : **201**
- Contenu :
```json
{
    "message": "Post created",
"data": {
        "title": "Consequatur dolor molestias rerum non et repellat nisi.",
        "body": "Consequatur laudantium ipsa et aliquam vitae vitae tempore. Animi dolore eum ut atque quo consectetur. Dolore corporis qui at facere. Minus accusamus rerum qui vero et.",
        "event_id": 1,
        "organization_id": 1,
        "user_id": 1,
        "color" : "#bc8a01"
    }
    
}
```

##### Erreur

- Code : **401**
- Contenu :
```json
{
    "message": "Unauthenticated."
}
```

- Code : **422**
- Contenu :
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "The title field is required."
        ],
        "body": [
            "The body field is required."
        ]
    }
}
```

### afficher les posts

Affiche tout les posts

| protocole | methode | url        | token |
|-----------|---------|------------|-------|
| https     | GET     | /api/post  | oui   |

#### Paramètres

Aucun

#### Réponses

##### succès

- Code : **200**
- 

