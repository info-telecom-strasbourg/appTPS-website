# InsidePSBS
## Introduction
InsidePSBS est une application mobile servant à la vie étudiante de Télecom Physique Strasbourg.
## API

L'api est disponible à l'adresse suivante : https://app-pprd.its-tps.fr/api (pour l'api de preprod) et https://app.its-tps.fr/api (pour l'api de prod).

### Authentification
L'authentification utiliser est le systéme sanctum de laravel. Pour s'authentifier il faut avoir un bariere token valide.

### Utilisation
Pour utiliser l'api il faut ajouter le bariere token dans le header de la requête http.

