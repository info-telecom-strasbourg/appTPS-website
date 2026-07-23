<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Disque de stockage
    |--------------------------------------------------------------------------
    */
    'disk' => 'public',

    /*
    |--------------------------------------------------------------------------
    | Dossier des avatars enregistrés (relatif à disk)
    |
    | Dans ce dossier se trouvent tous les avatars qui sont importés par les 
    | utilisateurs.
    |--------------------------------------------------------------------------
    */    
    'directory' => 'images/avatars',
    
    /*
    |--------------------------------------------------------------------------
    | Dossier des avatars pré-enregistrés (relatif à disk)
    |
    | Dans ce dossier se trouvent toutes images qui sont proposées à 
    | l'utilisateur par defaut.
    |--------------------------------------------------------------------------
    */
    'defaults_directory' => 'images/avatars/defaults',

    /*
    |--------------------------------------------------------------------------
    | Image par defaut (statique, située dans public/)
    |
    | C'est cette image qui sera affichée si aucun avatar n'est défini.
    |--------------------------------------------------------------------------
    */
    'fallback_image' => 'images/fallback-avatar.png',

];