# Liste les cgu

Permet d'afficher les cgu

## Requête

| protocole | methode | url      | token |
| --------- | ------- |----------| ----- |
| https     | GET     | /api/cgu | non   |

## Réponses

### Succès

`status : 200`

```json
[
   {
	"title": "CGU pour l'application InsidePSBS:",
	"sections": [
		{
			"title": "Politique de confidentialité pour l'application InsidePSBS:",
			"content": "Lorsque vous utilisez l'application InsidePSBS, nous collectons certaines informations vous concernant, notamment votre nom, prénom, identifiants relatifs à votre école (id, e-mail), vos photos de profil, vos appartenances à un club ou une association de l'école, ainsi que les informations nécessaires au fonctionnement de l'application (identifiants de notification). Ces informations sont nécessaires pour assurer le bon fonctionnement de l'application et pour faciliter la communication entre les utilisateurs. Elles ne seront jamais vendues à des tiers. Nous prenons la sécurité et la confidentialité de vos données très au sérieux. Nous avons mis en place des mesures de sécurité appropriées pour protéger vos données contre tout accès non autorisé, toute utilisation abusive, toute altération ou toute perte de données. Toutes les données sensibles sont chiffrées pour empêcher tout accès non autorisé. Les données sont stockées sur des serveurs sécurisés, qui sont régulièrement mis à jour et surveillés pour détecter toute violation de sécurité."
		},
		{
			"title": "Sécurité et confidentialité:",
			"content": "Nous prenons la sécurité et la confidentialité de vos données très au sérieux. Nous avons mis en place des mesures de sécurité appropriées pour protéger vos données contre tout accès non autorisé, toute utilisation abusive, toute altération ou toute perte de données. Toutes les données sensibles sont chiffrées pour empêcher tout accès non autorisé. Les données sont stockées sur des serveurs sécurisés, qui sont régulièrement mis à jour et surveillés pour détecter toute violation de sécurité."
		},
		{
			"title": "Vos droits:",
			"content": "Vous avez le droit de consulter les données que nous avons collectées vous concernant et de les supprimer si vous le souhaitez. Pour exercer ces droits, veuillez contacter un administrateur de l'application."
		},
		{
			"title": "Modifications de la politique de confidentialité:",
			"content": "Nous nous réservons le droit de modifier cette politique de confidentialité à tout moment, en publiant une version mise à jour sur notre site web ou sur l'application. Il est de votre responsabilité de consulter régulièrement cette politique de confidentialité pour prendre connaissance des éventuelles modifications."
		}
	]
]
```
