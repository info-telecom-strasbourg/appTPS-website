# InsidePSBS

## Dépendances

Pour ce projet, il est nécessaire de disposer des éléments suivants :

- [PHP (8.2)](https://www.php.net/releases/8.2/en.php)
- [MySQL](https://www.mysql.com/downloads/)
- [Composer](https://getcomposer.org/download/)

## Installation

### Cloner le projet

La commande suivante va cloner le projet, depuis les serveurs GitHub, dans le répertoire courant.

```bash
git clone git@github.com:info-telecom-strasbourg/appTPS-website.git
```

### Installation des packages

Une fois le projet cloné, il faut se déplacer dans le dossier et installer les dépendances. Pour cela, ouvrez un terminal et tapez la commande suivante :

```bash
composer install
```

## Configuration

Pour configurer les différents composants de l'applications, il faut copier et renomer le fichier `.env.example`, qui se trouve à la racine du projet, en `.env`et le compléter :

```bash
cp .env.example .env
```

### Bases de données

Il faut créer deux bases de données, une pour les données du BDE qui s'appellera `BdeData` et une pour les données de l'application qui s'appellera `apptps`. Pour cela vous pouvez utiliser mysql.

Pour configurer la connexion pour base de données du BDE, il faut compléter les lignes suivantes :

```bash
BDE_DB_CONNECTION=mysql
BDE_DB_HOST=
BDE_DB_PORT=
BDE_DB_DATABASE=BdeData
BDE_DB_USERNAME=
BDE_DB_PASSWORD=
```

Pour configurer la base de données de l'application,  Il faut compléter les lignes suivantes :

```bash
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

### Génération de la clé de chiffrement

Pour générer la clé de chiffrement, il faut ouvrir un terminal et taper la commande suivante :

```bash
php artisan key:generate
```

### Mise en place des liens symbolique pour le stockage

Pour rendre accessible l'espace de stockage public, il faut ouvrir un terminal et taper la commande suivante :

```bash
php artisan storage:link
```

Cela génère un lien symbolique entre `public/storage` et `storage/app/public`

## Utilisation

### Génération des tables avec les données

Pour créer les tables, il faut ouvrir un terminal et taper la commande suivante :

```bash
php artisan migrate:fresh
```

Si vous souhaitez créer les tables et générer des données aléatoires pour peupler les bases de données, tapez la commande suivante :

```bash
php artisan migrate:fresh --seed
```

### Lancement du serveur

Pour lancer le serveur, il faut ouvrir un terminal et taper la commande suivante :

```bash
php artisan serve
```
ou pour forcer l'ouverture sur les réseaux externes du serveur :

```bash
php artisan serve --host="0.0.0.0"
```

### Générer la documentation de l'API

> La Documentation de l'API publiée sur GitHub (branche gh-pages) est générée automatiquement à partir de la branche `dev` lors d'un push sur celle-ci.

Pour générer la documentation Scribe localement, il faut ouvrir un terminal et taper la commande suivante :

```bash
php artisan scribe:generate
```

Cette commande génère un fichier `docs/index.html` qui permet de consulter la documentation.

