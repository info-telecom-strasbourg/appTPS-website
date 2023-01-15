<!DOCTYPE html>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/logo/InsidePSBS.png') }}" type="image/x-icon">
    <title>Authentifcation refusée - AppTPS</title>
</head>

<body style="background-color:rgb(233,238,240)">

    <style>
        @keyframes example {
            from {
                background-color: #b085f5;
            }

            to {
                background-color: rgb(233, 238, 240);
            }
        }

        .center-image {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }

        .text {
            text-align: center;
            border: 0px solid;
            border-radius: 20px;
            padding: 30px;
            margin-left: auto;
            margin-right: auto;
            width: 60%;
            font-size: 2vw;
            animation-name: example;
            animation-duration: 4s;

        }
    </style>

    <p class="text">

        <img src="../../images/sentiment_very_dissatisfied_black_24dp.svg" width="100" height="100" class="center-image" />

        <?php

        use App\Http\Middleware\CheckCas;

        switch (CheckCas::getErrorAuth()) {

            case "udsfieldmissing":

                $errorType = "Le champ udsDisplayName est manquant. <br>"
                    . "Il est donc impossible de t'identifier. <br>"
                    . "Tu peux contacter ITS pour plus "
                    . "d'informations.";

                break;

            case "notadminmail":

                $errorType = "Tu n'as pas les droits pour entrer sur cette "
                    . "page !! <br> Tu dois avoir les droits administrateurs. ";

                break;

            case "notredactor":

                $errorType = "Tu n'as pas les droits pour entrer sur cette "
                    . "page !! <br> Tu dois avoir les droits de rédacteur. ";

                break;

            case "notfromtps":

                $errorType = "Oups, nous n'avons pas pu t'identifier. <br>"
                    . "Es-tu un.e étudiant.e de "
                    . "Télécom Physique Strasbourg ou de l'École "
                    . "Supérieure de Biotechnologie de Strasbourg ? <br> Si tu fais partie "
                    . "de TPS ou de l'ESBS, tu peux contacter ITS.";

                break;

            case 'mailfieldmissing':

                $errorType = "Nous n'arrivons pas à t'identifier comme "
                    . "admin puisque le champ mail du CAS est manquant.";

            default:

                $errorType = "Une erreur inconnue est survenue pendant "
                    . "l'authentification. Tu peux contacter ITS.";

                break;
        }

        echo $errorType;
        ?>

    </p>

</body>

</html>