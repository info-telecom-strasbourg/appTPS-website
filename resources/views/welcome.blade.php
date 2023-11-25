<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inside PSBS</title>

    <script type="module" crossorigin src="/js/index-8ef1cc3c.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js" defer></script>

    <script type="module" crossorigin src="/js/main.js"></script>


    <link rel="stylesheet" href="/css/index-26c21b6d.css">
    <link rel="stylesheet" href="/css/main.css">

    <style>
        .card-header {
            flex-direction: row;
            text-align: left;
        }

        body {
            text-align: center;
        }

        .card-header img {
            width: 20%;
            margin: 1.5em;
        }

        .badges-line {
            flex-direction: row;
        }

        .responsive-card {
            width: 50%;
            padding: 2em;
        }

        .badges {
            width: 40%;
        }


        @media screen and (orientation: portrait) {
            .px-20 {
                padding-left: 0;
                padding-right: 0;
            }

            .card {
                margin-top: 20px;
                margin-bottom: 20px;
            }

            .card-header img {
                width: 25%;
                margin: 1em;
            }

            .card-header {
                flex-direction: column;
                font-size: 1.05em;
                text-align: center;
            }

            .badges-line {
                flex-direction: column;
            }

            .responsive-card {
                width: 90%;
                padding: 1em;
            }

            .badges {
                width: 100%;
            }
        }
    </style>
</head>

<body class="flex h-screen w-screen flex-col items-center justify-between gap-10 bg-gray-950 px-20">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card responsive-card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center">
                        <img src="logo.png" class="card-img-top" alt="Logo InsidePSBS">
                        <div class="card-header" style="font-size: 2.5em">Bienvenue sur InsidePSBS !
                        </div>
                    </div>
                    <br>
                    <div class="card-body">
                        <p>InsidePSBS est une application à destination des étudiant.e.s de Télécom Physique Strasbourg
                            et de l'École Supérieure de Biotechnologies de Strasbourg !</p>
                        <p>Téléchargez vite notre app sur Android et iOS : </p>
                        <div class="row badges-line"
                            style="display: flex; justify-content: space-between; align-items: center; margin-inline: 3em">
                            <div class="col-md-6 badges">
                                <a href='https://play.google.com/store/apps/details?id=com.ITS.InsidePSBS&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'
                                    target=”_blank”><img alt='Disponible sur Google Play'
                                        src='https://play.google.com/intl/en_us/badges/static/images/badges/fr_badge_web_generic.png' /></a>
                            </div>
                            <div class="col-md-6 badges">
                                <a href="https://apps.apple.com/us/app/insidepsbs/id6446891622?itsct=apps_box_badge&amp;itscg=30200"
                                    style="display: inline-block; overflow: hidden; border-radius: 13px; height: 83px;"
                                    target=”_blank”><img
                                        src="https://tools.applemediaservices.com/api/badges/download-on-the-app-store/black/fr-fr?size=250x83&amp;releaseDate=1693180800"
                                        alt="Download on the App Store" style="border-radius: 13px; height: 83px;"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
