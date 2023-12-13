# InsidePSBS

## Installation

### Composer

Tout d'abord, il faut installer composer. Pour cela, rendez-vous sur le site officiel de [Composer](https://getcomposer.org/download/) et suivez les instructions.

### Installation du projet

Une fois composer installé, il faut cloner le projet.

### Installation des dépendances

Une fois le projet cloné, il faut se déplacer dans le dossier et installer les dépendances. Pour cela, ouvrez un terminal et tapez la commande suivante :

```bash
composer install
```

### Configuration des bases de données

Il faut créer deux bases de données, une pour les données du BDE qui s'appellera `BdeData` et une pour les données de l'application qui s'appellera `apptps`. Pour cela vous pouvez utiliser mysql ou sqlite.

Pour configurer la base de données du BDE, il faut modifier le fichier `.env` qui se trouve à la racine du projet. Il faut modifier les lignes suivantes :

```bash
BDE_DB_CONNECTION=mysql
BDE_DB_HOST=
BDE_DB_PORT=
BDE_DB_DATABASE=BdeData
BDE_DB_USERNAME=
BDE_DB_PASSWORD=
```

Pour configurer la base de données de l'application, il faut modifier le fichier `.env` qui se trouve à la racine du projet. Il faut modifier les lignes suivantes :

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

### Génération des tables avec les données

Pour générer les tables, il faut ouvrir un terminal et taper la commande suivante :

```bash
php artisan migrate:fresh --seed
```

### Lancement du serveur

Pour lancer le serveur, il faut ouvrir un terminal et taper la commande suivante :

```bash
php artisan serve
```
