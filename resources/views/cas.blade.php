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
                        <img src="../logo.png" class="card-img-top" alt="Logo InsidePSBS">
                        <div class="card-header" style="font-size: 2.5em">Compte Unistra relié !
                        </div>
                    </div>
                    <br>
                    <div class="card-body">
                        <p>Ton compte InsidePSBS est désormais relié au compte Unistra : <br>
                        </p>
                        <p style="background-color: green; border-radius: 10px; padding: 5%">
                            {{ $cas_infos['uid'] }}
                            -
                            {{ $cas_infos['udsDisplayName'] }}
                            - {{ $cas_infos['mail'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <button class="btn btn-primary" style="margin: auto; width: 40%; background-color: blue"
            onclick="window.ReactNativeWebView.postMessage('Back');">Retour à l'App</button>
    </div>
</body>

</html>
